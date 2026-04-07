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
     * how logbook form for daily logbook entry
     */
    public function logbookHarian()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        $mentors = Mentor::where('id', $student->internshipProgram->mentor_id)
            ->whereHas('user', function ($query) {
                $query->where('is_active', true);
            })
            ->with('user')
            ->get();

        return view('student.logbook.create', compact('mentors', 'student'));
    }

    /**
     * Save new logbook entry
     */
    public function store(Request $request)
    {
        $request->validate([
            'mentor_id' => 'required|exists:users,id,role,mentor',
            'notes' => 'required|string|min:10|max:2000',
            'documentation_file' => 'nullable|file|mimes:pdf,doc,docx,zip,rar|max:10240',
        ]);

        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return response()->json(['error' => 'Data siswa tidak ditemukan.'], 404);
        }

        $assignedMentorUserId = $student->internshipProgram->mentor->user_id;
        if ($request->mentor_id != $assignedMentorUserId) {
            return response()->json(['error' => 'Gagal! Anda hanya boleh mengirim logbook ke mentor pendamping Anda.'], 403);
        }

        $filePath = null;
        if ($request->hasFile('documentation_file')) {
            $file = $request->file('documentation_file');
            $fileName = time() . '_' . $student->id . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('logbooks', $fileName, 'public');
        }

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
     * Show logbook index
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
     * Form edit logbook.
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

        if (!in_array($logbook->status, ['rejected', 'pending'])) {
            return redirect()->route('student.logbook.index')
                ->with('error', 'Logbook yang sudah disetujui tidak dapat diedit.');
        }

        $mentors = Mentor::where('id', $student->internshipProgram->mentor_id)
            ->whereHas('user', function ($query) {
                $query->where('is_active', true);
            })
            ->with('user')
            ->get();

        return view('student.logbook.edit', compact('logbook', 'mentors'));
    }

    /**
     * Update logbook entry. Only allowed if status is 'pending' or 'rejected'.
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

        if (!in_array($logbook->status, ['rejected', 'pending'])) {
            return response()->json(['error' => 'Hanya logbook Pending atau Ditolak yang dapat diperbarui.'], 403);
        }

        $assignedMentorUserId = $student->internshipProgram->mentor->user_id;
        if ($request->mentor_id != $assignedMentorUserId) {
            return response()->json(['error' => 'Mentor tidak valid untuk program Anda.'], 403);
        }

        $filePath = $logbook->documentation_file;
        if ($request->hasFile('documentation_file')) {
            if ($logbook->documentation_file) {
                Storage::disk('public')->delete($logbook->documentation_file);
            }

            $file = $request->file('documentation_file');
            $fileName = time() . '_' . $student->id . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('logbooks', $fileName, 'public');
        }

        $logbook->update([
            'mentor_id' => $request->mentor_id,
            'notes' => $request->notes,
            'documentation_file' => $filePath,
            'status' => 'pending', 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Logbook berhasil diperbarui dan dikirim ulang untuk divalidasi!'
        ]);
    }
}