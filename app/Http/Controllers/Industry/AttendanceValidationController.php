<?php

namespace App\Http\Controllers\Industry;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class AttendanceValidationController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index()
{
    $user = Auth::user();

    if (!in_array($user->role, ['owner', 'mentor'])) {
        abort(403, 'Unauthorized action.');
    }

    $industryId = $user->industry_id;

    // Jika Owner, tampilkan semua sekolah di industrinya
    if ($user->role === 'owner') {
        $schools = School::where('industry_id', $industryId)->get();
    } 
    // 🔥 Jika Mentor (Tanu), filter hanya sekolah yang ada siswa bimbingannya
    else {
        $schools = School::where('industry_id', $industryId)
            ->whereHas('students', function ($query) use ($user) {
                $query->whereHas('internshipProgram', function ($q) use ($user) {
                    $q->where('mentor_id', $user->mentor->id);
                });
            })->get();
    }

    return view('industry.attendance-validation.index', compact('schools'));
}

    public function show($id)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['owner', 'mentor'])) {
            abort(403, 'Unauthorized action.');
        }

        // Cari School berdasarkan $id, pastikan industry_id sesuai
        $industryId = $user->industry_id ?? -1;
        if ($user->role === 'mentor' && $user->mentor) {
            $industryId = $user->mentor->industry_id;
        }
        $school = School::where('industry_id', $industryId)->findOrFail($id);

        $sessionId = request('session_id') ?? \App\Models\AttendanceSession::where('industry_id', $industryId)->latest()->value('id');

        $students = \App\Models\Student::where('school_id', $school->id)
            ->where('industry_id', $industryId)
            ->with(['attendances' => function ($query) use ($sessionId) {
                // Ambil data absen KHUSUS untuk sesi yang sedang divalidasi
                $query->where('attendance_session_id', $sessionId);
            }, 'user'])
            ->paginate(30);

        return view('industry.attendance-validation.show', compact('school', 'students', 'sessionId'));
    }
}
