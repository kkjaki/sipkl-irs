<?php

namespace App\Http\Controllers\Industry;

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

        $industryId = null;
        if ($user->role === 'owner') {
            $industryId = $user->industry->id ?? null;
        } elseif ($user->role === 'mentor') {
            $industryId = $user->mentor->industry_id ?? null;
        }

        // Menampilkan sesi tanpa mempedulikan status aktif/non-aktif
        $attendanceSessions = $industryId
            ? AttendanceSession::where('industry_id', $industryId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);

        return view('industry.attendanceSessions.index', compact('attendanceSessions'));
    }

    public function create()
    {
        return view('industry.attendanceSessions.create');
    }

    /**
     * Pengecekan agar tidak ada sesi ganda di hari yang sama.
     */
    public function store(Request $request)
    {
        // Validasi HANYA untuk jam (Karena nama dan tanggal di-generate otomatis)
        $validated = $request->validate([
            'on_time_deadline' => 'required',
            'closed_at' => 'required',
        ]);

        $user = Auth::user();

        // Cek identitas: Dia ini Bos atau Mentor?
        $industryId = null;
        if ($user->role === 'owner') {
            $industryId = $user->industry->id ?? null;
        } elseif ($user->role === 'mentor') {
            $industryId = $user->mentor->industry_id ?? null;
        }

        if (!$industryId) {
            return redirect()->back()->withErrors(['error' => 'Industri tidak ditemukan pada akun Anda.'])->withInput();
        }

        // Set tanggal hari ini secara otomatis
        $sessionDate = now()->toDateString();

        // Cek sesi ganda: Jangan sampai ada sesi dengan jam buka yang SAMA di hari yang SAMA
        $exists = \App\Models\AttendanceSession::where('industry_id', $industryId)
            ->where('session_date', $sessionDate)
            ->where('on_time_deadline', $validated['on_time_deadline'])
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['on_time_deadline' => 'Sesi di jam ini untuk hari ini sudah ada.'])->withInput();
        }

        // Simpan ke database (Tanpa kolom 'name')
        \App\Models\AttendanceSession::create([
            'industry_id' => $industryId,
            'opened_by_user_id' => $user->id,
            'session_date' => $sessionDate,
            'on_time_deadline' => $validated['on_time_deadline'],
            'closed_at' => $validated['closed_at'],
            'is_open' => true,
        ]);

        // Kembali ke halaman index dengan pesan sukses
        return redirect()->route('attendance-sessions.index')
            ->with('success', 'Sesi presensi berhasil dibuka!');
    }

    /**
     * Otorisasi agar detail sesi tidak bisa diintip industri lain.
     */
    public function show(AttendanceSession $attendanceSession)
    {
        $this->authorizeAccess($attendanceSession);
        $attendanceSession->load(['user', 'industry', 'attendances']);
        return view('industry.attendanceSessions.show', compact('attendanceSession'));
    }

    public function edit(AttendanceSession $attendanceSession)
    {
        $this->authorizeAccess($attendanceSession);
        return view('industry.attendanceSessions.edit', compact('attendanceSession'));
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
