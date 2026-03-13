<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Attendance;
use App\Models\AttendanceSession;

class AttendanceController extends Controller
{
    /**
     * Display the daily attendance page with available sessions.
     */
    public function presensiHarian()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        // Get today's date
        $today = now()->toDateString();

        // Get attendance sessions for today that are open
        $attendanceSessions = AttendanceSession::where('session_date', $today)
            ->where('is_open', true)
            ->with('user')
            ->get();

        // Check if student already has attendance for each session
        $attendanceSessions->each(function ($session) use ($student) {
            $existingAttendance = Attendance::where('attendance_session_id', $session->id)
                ->where('student_id', $student->id)
                ->first();

            $session->already_attended = $existingAttendance !== null;
            $session->attendance_data = $existingAttendance;
        });

        return view('student.presensi-harian', compact('attendanceSessions', 'student'));
    }

    /**
     * Store a new attendance record with image.
     */
    public function store(Request $request)
    {
        $request->validate([
            'attendance_session_id' => 'required|exists:attendance_sessions,id',
            'status' => 'required|in:hadir,izin,sakit',
            'image' => 'required|image|max:5120', // Max 5MB
            'notes' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return response()->json(['error' => 'Data siswa tidak ditemukan.'], 404);
        }

        // Verify the session belongs to the student's industry
        $session = AttendanceSession::findOrFail($request->attendance_session_id);
        if ($session->industry_id !== $student->internshipProgram->industry_id) {
            return response()->json(['error' => 'Sesi presensi tidak valid.'], 403);
        }

        // Check if already attended
        $existingAttendance = Attendance::where('attendance_session_id', $request->attendance_session_id)
            ->where('student_id', $student->id)
            ->first();

        if ($existingAttendance) {
            return response()->json(['error' => 'Anda sudah melakukan presensi untuk sesi ini.'], 400);
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $student->id . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('attendances', $imageName, 'public');
        }

        // Create attendance record
        Attendance::create([
            'attendance_session_id' => $request->attendance_session_id,
            'student_id' => $student->id,
            'status' => $request->status,
            'check_in' => now('+07:00'),
            'notes' => $request->notes,
            'image' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil disimpan!'
        ]);
    }

    /**
     * Display the attendance history page.
     */
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        $attendances = Attendance::where('student_id', $student->id)
            ->with('session')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('student.presensi-index', compact('attendances'));
    }
}