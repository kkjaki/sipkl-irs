<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Logbook;
use App\Models\Mentor;

class LogbookController extends Controller
{
    /**
     * Display the daily logbook creation form.
     */
    public function logbookHarian()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        // Get active mentors from the same industry
        $mentors = Mentor::whereHas('user', function ($query) {
            $query->where('is_active', true);
        })
            ->with('user')
            ->get();

        return view('student.logbook.create', compact('mentors', 'student'));
    }

    /**
     * Store a new logbook entry.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mentor_id' => 'required|exists:users,id,role,mentor',
            'notes' => 'required|string|min:10|max:2000',
            'documentation_file' => 'nullable|file|mimes:pdf,doc,docx,zip,rar|max:10240', // Max 10MB
        ]);

        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return response()->json(['error' => 'Data siswa tidak ditemukan.'], 404);
        }

        // Verify mentor belongs to student's industry
        $mentor = Mentor::where('user_id', $request->mentor_id)
            ->first();

        if (!$mentor) {
            return response()->json(['error' => 'Mentor tidak valid.'], 403);
        }

        // Handle documentation file upload
        $filePath = null;
        if ($request->hasFile('documentation_file')) {
            $file = $request->file('documentation_file');
            $fileName = time() . '_' . $student->id . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('logbooks', $fileName, 'public');
        }

        // Create logbook entry
        Logbook::create([
            'student_id' => $student->id,
            'mentor_id' => $request->mentor_id,
            'notes' => $request->notes,
            'documentation_file' => $filePath,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Logbook berhasil disimpan dan menunggu validasi mentor!'
        ]);
    }

    /**
     * Display the logbook list page.
     */
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        $logbooks = Logbook::where('student_id', $student->id)
            ->with('mentor')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('student.logbook.index', compact('logbooks'));
    }

    /**
     * Show the form for editing a logbook.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $student = $user->student;

        $logbook = Logbook::where('id', $id)
            ->where('student_id', $student->id)
            ->first();

        if (!$logbook) {
            return redirect()->route('student.logbook.index')
                ->with('error', 'Logbook tidak ditemukan.');
        }

        // Only allow editing if status is rejected
        if ($logbook->status !== 'rejected') {
            return redirect()->route('student.logbook.index')
                ->with('error', 'Hanya logbook yang ditolak yang dapat diedit.');
        }

        $mentors = Mentor::where('industry_id', $student->internshipProgram->industry_id)
            ->whereHas('user', function ($query) {
            $query->where('is_active', true);
        })
            ->with('user')
            ->get();

        return view('student.logbook.edit', compact('logbook', 'mentors'));
    }

    /**
     * Update a logbook entry.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'mentor_id' => 'required|exists:users,id,role,mentor',
            'notes' => 'required|string|min:10|max:2000',
            'documentation_file' => 'nullable|file|mimes:pdf,doc,docx,zip,rar|max:10240',
        ]);

        $user = Auth::user();
        $student = $user->student;

        $logbook = Logbook::where('id', $id)
            ->where('student_id', $student->id)
            ->first();

        if (!$logbook) {
            return response()->json(['error' => 'Logbook tidak ditemukan.'], 404);
        }

        if ($logbook->status !== 'rejected') {
            return response()->json(['error' => 'Hanya logbook yang ditolak yang dapat diedit.'], 403);
        }

        // Verify mentor belongs to student's industry
        $mentor = Mentor::where('user_id', $request->mentor_id)
            ->where('industry_id', $student->internshipProgram->industry_id)
            ->first();

        if (!$mentor) {
            return response()->json(['error' => 'Mentor tidak valid.'], 403);
        }

        // Handle documentation file upload
        $filePath = $logbook->documentation_file;
        if ($request->hasFile('documentation_file')) {
            // Delete old file if exists
            if ($logbook->documentation_file) {
                Storage::disk('public')->delete($logbook->documentation_file);
            }

            $file = $request->file('documentation_file');
            $fileName = time() . '_' . $student->id . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('logbooks', $fileName, 'public');
        }

        // Update logbook entry
        $logbook->update([
            'mentor_id' => $request->mentor_id,
            'notes' => $request->notes,
            'documentation_file' => $filePath,
            'status' => 'pending', // Reset to pending when resubmitting
        ]);

        return redirect()->route('student.logbook.index')
            ->with('success', 'Logbook berhasil diperbarui dan menunggu validasi mentor!');
    }
}