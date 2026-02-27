<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSession;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class AttendanceSessionController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Filter industry_id agar data tidak bocor antar perusahaan.
     */
    public function index()
    {
        $user = Auth::user();

        // Hanya menampilkan sesi milik industri user yang sedang login
        $attendanceSessions = AttendanceSession::where('industry_id', $user->industry->id)
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('attendanceSessions.index', compact('attendanceSessions'));
    }

    public function create()
    {
        return view('attendanceSessions.create');
    }

    /**
     * Pengecekan agar tidak ada sesi ganda di hari yang sama.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'session_date' => 'required|date',
            'on_time_deadline' => 'required',
            'closed_at' => 'required',
            'industry_id' => 'required'
        ]);

        $user = Auth::user();

        $industryId = $user->industry->id ?? $request->industry_id;

        $exists = AttendanceSession::where('industry_id', $industryId)
            ->where('session_date', $request->session_date)
            ->exists();

        if ($exists) {
            return response()->json(['error' => 'Sesi untuk tanggal ini sudah ada.'], 422);
        }

        $validated['opened_by_user_id'] = $user->id;
        $validated['industry_id'] = $industryId;
        $validated['is_open'] = true;

        $session = AttendanceSession::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Sesi Presensi berhasil dibuka!',
            'data' => $session
        ], 201);
    }

    /**
     * Otorisasi agar detail sesi tidak bisa diintip industri lain.
     */
    public function show(AttendanceSession $attendanceSession)
    {
        $this->authorizeAccess($attendanceSession);
        $attendanceSession->load(['user', 'industry', 'attendances']);
        return view('attendanceSessions.show', compact('attendanceSession'));
    }

    public function edit(AttendanceSession $attendanceSession)
    {
        $this->authorizeAccess($attendanceSession);
        return view('attendanceSessions.edit', compact('attendanceSession'));
    }

    public function update(Request $request, AttendanceSession $attendanceSession)
    {
        $this->authorizeAccess($attendanceSession);

        $validatedData = $request->validate([
            'session_date' => 'required|date',
            'on_time_deadline' => 'required|date_format:H:i',
            'closed_at' => 'nullable|date_format:H:i|after:on_time_deadline',
        ]);

        $validatedData['is_open'] = $request->has('is_open');
        $attendanceSession->update($validatedData);

        return redirect()->route('attendanceSessions.index')->with('success', 'Sesi Presensi berhasil diperbarui.');
    }

    public function destroy(AttendanceSession $attendanceSession)
    {
        $this->authorizeAccess($attendanceSession);

        $attendanceSession->delete();
        return redirect()->route('attendanceSessions.index')->with('success', 'Sesi Presensi berhasil dihapus.');
    }

    /**
     * Helper Method: Mengamankan akses agar hanya Owner/Mentor di industri yang sama yang bisa akses.
     * Ini membuat kode lebih clean karena dipanggil di show, edit, update, dan destroy.
     */
    protected function authorizeAccess(AttendanceSession $attendanceSession)
    {
        $user = Auth::user();

        $isOwner = $user->id === $attendanceSession->industry->owner_id;
        $isMentor = Mentor::where('industry_id', $attendanceSession->industry_id)
            ->where('user_id', $user->id)
            ->exists();

        if (!$isOwner && !$isMentor) {
            abort(403, 'Anda tidak memiliki akses ke sesi industri lain.');
        }
    }

    /**
     * Menutup sesi presensi secara manual.
     */
    public function close(AttendanceSession $attendanceSession)
    {
        $this->authorizeAccess($attendanceSession);

        $attendanceSession->update(['is_open' => false]);

        if (request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Sesi presensi resmi ditutup!',
                'data' => $attendanceSession
            ]);
        }

        return redirect()->back()->with('success', 'Sesi presensi telah ditutup.');
    }
}
