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

        $attendanceCounts = [
            'hadir' => 0,
            'izin_sakit' => 0,
            'terlambat' => 0,
            'tidak_hadir' => 0,
        ];

        $earnedPoints = 0;
        $maxPoints = 0;
        $disciplineScore = 0;

        if ($student) {
            $result = \App\Models\Attendance::where('student_id', $student->id)
                ->selectRaw("
                SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as hadir,
                SUM(CASE WHEN status IN ('izin', 'sakit') THEN 1 ELSE 0 END) as izin_sakit,
                SUM(CASE WHEN status = 'alpa' THEN 1 ELSE 0 END) as tidak_hadir
            ")
                ->first();

            $terlambat = \App\Models\Attendance::where('student_id', $student->id)
                ->join('attendance_sessions', 'attendances.attendance_session_id', '=', 'attendance_sessions.id')
                ->whereNotNull('attendance_sessions.on_time_deadline')
                ->whereRaw('DATE(attendances.check_in) = attendance_sessions.session_date')
                ->whereRaw('TIME(attendances.check_in) > attendance_sessions.on_time_deadline')
                ->count();

            $tidakHadirFromStatus = (int) ($result->tidak_hadir ?? 0);
            $alphaCount = $tidakHadirFromStatus;

            if ($student->internshipProgram) {
                $today      = \Carbon\Carbon::now()->startOfDay();
                $programEnd = \Carbon\Carbon::parse($student->internshipProgram->end_date)->startOfDay();
                $countUntil = $today->lt($programEnd) ? $today : $programEnd;

                $sessions = \App\Models\AttendanceSession::where('industry_id', $student->internshipProgram->industry_id)
                    ->whereDate('session_date', '<=', $countUntil)
                    ->get();

                $sessionIds = $sessions->pluck('id');

                // Sesi yang sudah lewat tapi siswa tidak punya data presensi sama sekali
                $totalSudahAbsen = \App\Models\Attendance::where('student_id', $student->id)
                    ->whereIn('attendance_session_id', $sessionIds)
                    ->count();

                $sesiTidakAbsen = $sessions->count() - $totalSudahAbsen;

                // Alpha = sesi tidak diabsen + baris dengan status 'alpa'
                $alphaCount = $sesiTidakAbsen + $tidakHadirFromStatus;

                // ── Discipline Points ──────────────────────────────────────────
                $maxPoints = $sessions->count() * 3;

                $attendances = \App\Models\Attendance::where('student_id', $student->id)
                    ->join('attendance_sessions', 'attendances.attendance_session_id', '=', 'attendance_sessions.id')
                    ->whereIn('attendances.attendance_session_id', $sessionIds)
                    ->select(
                        'attendances.status',
                        'attendances.check_in',
                        'attendance_sessions.session_date',
                        'attendance_sessions.on_time_deadline'
                    )
                    ->get();

                foreach ($attendances as $att) {
                    if (in_array($att->status, ['izin', 'sakit'])) {
                        $earnedPoints += 1;
                    } elseif ($att->status === 'hadir') {
                        $checkIn  = strtotime($att->check_in);
                        $deadline = strtotime($att->session_date . ' ' . $att->on_time_deadline);
                        $earnedPoints += ($checkIn <= $deadline) ? 3 : 2;
                    }
                    // alpa = 0
                }

                $disciplineScore = $maxPoints > 0
                    ? round(($earnedPoints / $maxPoints) * 100, 1)
                    : 0;
            }

            if ($result) {
                $attendanceCounts = [
                    'hadir'       => (int) $result->hadir,
                    'izin_sakit'  => (int) $result->izin_sakit,
                    'terlambat'   => $terlambat,
                    'tidak_hadir' => $alphaCount,
                ];
            }
        }

        $grades = collect();
        if ($student !== null) {
            $grades = \App\Models\Grade::where('student_id', $student->id)
                ->with('criterion')
                ->get();
        }

        $recentLogbooks = collect();
        if ($student !== null) {
            $recentLogbooks = \App\Models\Logbook::where('student_id', $student->id)
                ->with('mentor')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        return view('student.dashboard.index', compact(
            'user',
            'student',
            'attendanceCounts',
            'grades',
            'recentLogbooks',
            'earnedPoints',
            'maxPoints',
            'disciplineScore',
        ));
    }
}
