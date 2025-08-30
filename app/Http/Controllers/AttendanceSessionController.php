<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSession;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class AttendanceSessionController extends BaseController
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load relationships for efficiency and paginate the results.
        $attendanceSessions = AttendanceSession::with('user')->latest()->paginate(15);

        return view('attendanceSessions.index', compact('attendanceSessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('attendanceSessions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'session_date' => 'required|date',
            'on_time_deadline' => 'required|date_format:H:i',
            'closed_at' => 'nullable|date_format:H:i|after:on_time_deadline',
        ]);

        $user = Auth::user();

        // Ensure user has an associated industry
        if (! $user->industry) {
            return back()->with('error', 'Anda tidak terhubung dengan industri manapun.');
        }

        $validatedData['opened_by_user_id'] = $user->id;
        $validatedData['industry_id'] = $user->industry->id;

        AttendanceSession::create($validatedData);

        return redirect()->route('attendanceSessions.index')->with('success', 'Sesi Presensi berhasil dibuka.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceSession $attendanceSession)
    {
        // Eager load relations for the detail view
        $attendanceSession->load(['user', 'industry', 'attendances']);

        return view('attendanceSessions.show', compact('attendanceSession'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendanceSession $attendanceSession)
    {
        return view('attendanceSessions.edit', compact('attendanceSession'));
    }

    /**
     * Update the specified resource in storage.
    */
    public function update(Request $request, AttendanceSession $attendanceSession)
    {
        $validatedData = $request->validate([
            'session_date' => 'required|date',
            'on_time_deadline' => 'required|date_format:H:i',
            'closed_at' => 'nullable|date_format:H:i|after:on_time_deadline',
        ]);

        // Handle boolean 'is_open' from checkbox
        $validatedData['is_open'] = $request->has('is_open');

        $attendanceSession->update($validatedData);

        return redirect()->route('attendanceSessions.index')->with('success', 'Sesi Presensi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceSession $attendanceSession)
    {
        $user = Auth::user();
        $industry = $attendanceSession->industry;

        // Authorization check: user must be the industry owner or a mentor in that industry.
        // This is a good candidate for a Policy class (e.g., AttendanceSessionPolicy).
        $isOwner = $user->id === $industry->owner_id;
        $isMentor = Mentor::where('industry_id', $industry->id)
            ->where('user_id', $user->id)
            ->exists();

        if (! $isOwner && ! $isMentor) {
            abort(403, 'Unauthorized action.');
        }

        $attendanceSession->delete();

        return redirect()->route('attendanceSessions.index')->with('success', 'Sesi Presensi berhasil dihapus.');
    }
}
