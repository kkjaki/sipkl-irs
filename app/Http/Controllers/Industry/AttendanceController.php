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
            'updates.*.status' => 'required|in:hadir,izin,sakit,alpa,terlambat',
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
 

    /**
     * Menampilkan Halaman Validasi Presensi Siswa (Daftar Siswa)
     */
    public function show($id)
    {
        // 1. Ambil data Sesi Presensi beserta relasi Industry dan School
        // Pastikan relasi 'school' sudah ada di model AttendanceSession
        $session = \App\Models\AttendanceSession::with(['industry', 'school'])->findOrFail($id);

        // 2. Otorisasi Keamanan: Pastikan hanya Owner/Mentor yang bisa akses
        $user = Auth::user();
        $isOwner = $user->id === $session->industry->owner_id;
        $isMentor = \App\Models\Mentor::where('industry_id', $session->industry_id)
            ->where('user_id', $user->id)
            ->exists();

        if (!$isOwner && !$isMentor) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses sesi ini.');
        }

        // 3. Ambil daftar siswa yang terdaftar di sekolah tersebut
        $students = \App\Models\Student::where('school_id', $session->school_id)
            ->with(['user', 'attendances' => function($query) use ($session) {
                $query->where('attendance_session_id', $session->id);
            }])
            ->paginate(10);

        // 4. Kirim data ke View (Gunakan view yang sudah kita buat tadi)
        return view('industry.attendance-validation.show', [ 
    'school' => $session->school,
    'students' => $students,
    'sessionId' => $session->id
        ]);
    }

}
