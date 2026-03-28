<?php

namespace App\Http\Controllers;

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

        $schools = $user->industry_id ? School::where('industry_id', $user->industry_id)->get() : collect();
        
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
        $school = School::where('industry_id', $industryId)->findOrFail($id);

        // Mengambil data Attendance dimana relasi student-nya memiliki school_id yang sama dengan $id sekolah
        $attendances = \App\Models\Attendance::whereHas('student', function ($query) use ($school) {
            $query->where('school_id', $school->id);
        })
        ->with(['student.user', 'session'])
        ->join('attendance_sessions', 'attendances.attendance_session_id', '=', 'attendance_sessions.id')
        ->orderBy('attendance_sessions.session_date', 'desc')
        ->select('attendances.*')
        ->paginate(30);

        return view('industry.attendance-validation.show', compact('school', 'attendances'));
    }
}