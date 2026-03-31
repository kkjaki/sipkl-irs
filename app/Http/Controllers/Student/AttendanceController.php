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

        $program = $student->internshipProgram;
        $industryId = $program->industry_id;
        $mentorId = $program->mentor_id;

        $validCreatorIds =  [];

        $ownerUserId = \App\Models\User::where('role', 'owner')
            ->whereHas('industry', function ($q) use ($industryId) {
                $q->where('id', $industryId);
            })->value('id');

        if ($ownerUserId) $validCreatorIds[] = $ownerUserId;

        if ($mentorId) {
            $mentorUserId = \App\Models\Mentor::find($mentorId)->user_id ?? null;
            if ($mentorUserId) $validCreatorIds[] = $mentorUserId;
        }

        $attendanceSessions = AttendanceSession::where('session_date', $today)
            ->where('is_open', true)
            ->where('industry_id', $industryId)
            ->whereIn('opened_by_user_id', $validCreatorIds)
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

    public function index()
{
    $student = auth()->user()->student;
    
    // Ambil data presensi si siswa, urutkan dari yang terbaru
    $attendances = \App\Models\Attendance::where('student_id', $student->id)
                    ->latest()
                    ->paginate(10);

    return view('student.presensi.index', compact('attendances', 'student'));
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
            'latitude' => 'required_if:status,hadir|nullable|numeric',
            'longitude' => 'required_if:status,hadir|nullable|numeric'
        ]);

        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return response()->json(['error' => 'Data siswa tidak ditemukan.'], 404);
        }

        $session = AttendanceSession::findOrFail($request->attendance_session_id);

        $program = $student->internshipProgram;

        $industry = $session->industry;

        $isValidIndustry = $session->industry_id == $program->industry_id;

        $mentorId = $program->mentor_id;

        $mentorUserId = $mentorId ? \App\Models\Mentor::find($mentorId)->user_id ?? null : null;

        $isCreatedByMentor = $session->opened_by_user_id == $mentorUserId;

        $isCreatedByOwner = \App\Models\User::where('id', $session->opened_by_user_id)->value('role') == 'owner';

        if (!$isValidIndustry || (!$isCreatedByMentor && !$isCreatedByOwner)) {
            return response()->json(['error' => "Sesi tidak valid. (Debug: Ind=$isValidIndustry, Men=$isCreatedByMentor, Own=$isCreatedByOwner)"], 403);
        }

        if ($request->status === 'hadir') {
            if (!$industry->latitude || !$industry->longitude) {
                return response()->json(['error' => 'Titik kordinat PT belum diatur oleh Admin. Silakan hubungi Mentor/Owner.'], 400);
            }
            // Havershine
            $earthRadius = 6371000;
            $latFrom = deg2rad((float) $industry->latitude);
            $lonFrom = deg2rad((float) $industry->longitude);
            $latTo = deg2rad((float) $request->latitude);
            $lonTo = deg2rad((float) $request->longitude);

            $latDelta = $latTo - $latFrom;
            $lonDelta = $lonTo - $lonFrom;

            $a = sin($latDelta / 2) * sin($latDelta / 2) +
                cos($latFrom) * cos($latTo) * sin($lonDelta / 2) *
                sin($lonDelta / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distance = $earthRadius * $c;

            $maxRadius = 250; // Edit sesuai kebutuhan, dalam meter

            if ($distance > $maxRadius) {
                $jarakBulat = round($distance);
                return response()->json(['error' => "Lokasi Anda di luar jangkauan PT! Jarak Anda: {$jarakBulat} meter. (Maksimal jarak: {$maxRadius} meter)"], 400);
            }

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
}
