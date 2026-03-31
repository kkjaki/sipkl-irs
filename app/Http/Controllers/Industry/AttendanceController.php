<?php

namespace App\Http\Controllers\Industry;

use App\Http\Controllers\Controller;

use App\Models\Attendance; 
use App\Models\AttendanceSession;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AttendanceController extends Controller
{
    /**
     * Validasi Presensi
     */
    public function update(Request $request, AttendanceSession $session)
    {
        $user = Auth::user();

        $isOwner = $user->id === $session->industry->owner_id;
        $isMentor = Mentor::where('industry_id', $session->industry_id)
            ->where('user_id', $user->id)
            ->exists();

        if (!$isOwner && !$isMentor) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'updates' => 'required|array',
            'updates.*.student_id' => 'required|exists:students,id',
            'updates.*.status' => 'required|in:hadir,izin,sakit,alpa',
        ]);

        foreach ($request->updates as $update) {
            Attendance::updateOrCreate(
                [
                    'attendance_session_id' => $session->id,
                    'student_id' => $update['student_id']
                ],
                [
                    'status' => $update['status']
                ]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Perubahan presensi berhasil disimpan',
            'data' => $request->updates
        ]);
    }
}
