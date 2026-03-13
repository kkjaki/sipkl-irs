<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $student = $user->student()->with([
            'internshipProgram.industry',
            'school',
            'schoolSupervisor',
        ])->first();

        // Attendance summary
        $attendanceCounts = [
            'hadir' => 0,
            'izin_sakit' => 0,
            'terlambat' => 0,
            'tidak_hadir' => 0,
        ];

        if ($student) {
            $result = \App\Models\Attendance::where('student_id', $student->id)
                ->selectRaw("
                    SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as hadir,
                    SUM(CASE WHEN status IN ('izin', 'sakit') THEN 1 ELSE 0 END) as izin_sakit,
                    SUM(CASE WHEN status = 'alpa' THEN 1 ELSE 0 END) as tidak_hadir
                ")
                ->first();

            // Count late attendance (checked in after deadline)
            $terlambat = \App\Models\Attendance::where('student_id', $student->id)
                ->join('attendance_sessions', 'attendances.attendance_session_id', '=', 'attendance_sessions.id')
                ->whereNotNull('attendance_sessions.on_time_deadline')
                ->whereRaw('DATE(attendances.check_in) = attendance_sessions.session_date')
                ->whereRaw('TIME(attendances.check_in) > attendance_sessions.on_time_deadline')
                ->count();

            if ($result) {
                $attendanceCounts = [
                    'hadir' => (int)$result->hadir,
                    'izin_sakit' => (int)$result->izin_sakit,
                    'terlambat' => $terlambat,
                    'tidak_hadir' => (int)$result->tidak_hadir,
                ];
            }
        }

        // Grades with criteria
        $grades = collect();
        if ($student !== null) {
            $grades = \App\Models\Grade::where('student_id', $student->id)
                ->with('criterion')
                ->get();
        }

        // Recent logbooks
        $recentLogbooks = collect();
        if ($student !== null) {
            $recentLogbooks = \App\Models\Logbook::where('student_id', $student->id)
                ->with('mentor')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        return view('student.dashboard', compact('user', 'student', 'attendanceCounts', 'grades', 'recentLogbooks'));
    }
}