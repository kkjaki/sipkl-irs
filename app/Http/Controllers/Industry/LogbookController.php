<?php

namespace App\Http\Controllers\Industry;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogbookController extends Controller
{
    /**
     * Helper function biar nggak ngulang kodingan filter yang panjang
     * Ini level dewa: DRY (Don't Repeat Yourself) 🚀
     */
    private function getLogbookBaseQuery()
    {
        $user = auth()->user();
        $isMentor = $user->role === 'mentor';

        $mentorId = $isMentor ? ($user->mentor->id ?? null) : null;
        $userIndustryId = $isMentor ? ($user->mentor->industry_id ?? null) : ($user->industry->id ?? null);

        return Logbook::whereHas('student', function ($query) use ($isMentor, $mentorId, $userIndustryId) {
            if ($isMentor) {
                $query->whereHas('internshipProgram', function ($q) use ($mentorId) {
                    $q->where('mentor_id', $mentorId);
                });
            } else {
                $query->where('industry_id', $userIndustryId)
                    ->orWhereHas('internshipProgram', function ($q) use ($userIndustryId) {
                        $q->where('industry_id', $userIndustryId);
                    });
            }
        });
    }

    /**
     *  Mengambil data logbook yang perlu divalidasi
     */
    public function index()
    {
        $logbooks = $this->getLogbookBaseQuery()
            ->with(['student.user', 'student.school'])
            ->latest()
            ->paginate(30);

        return view('industry.logbooks.index', compact('logbooks'));
    }

    /**
     * 2. Memproses validasi (Approve atau Reject)
     */
    //  INDIVIDU 
    public function edit($id)
    {
        $logbook = $this->getLogbookBaseQuery()
            ->with(['student.user'])
            ->findOrFail($id);
            
        return view('industry.logbooks.edit', compact('logbook'));
    }

    public function validateLogbook(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,revision',
            'feedback' => 'nullable|string'
        ]);

        $logbook = $this->getLogbookBaseQuery()->findOrFail($id);

        $logbook->status = $request->status;
        $logbook->feedback = $request->feedback;
        $logbook->save();

        if ($request->wantsJson() || $request->header('Accept') == 'application/json') {
            return response()->json([
                'message' => 'Status logbook ID ' . $id . ' berhasil diperbarui',
                'data' => $logbook
            ]);
        }
        return redirect()->route('industry.logbooks.index')->with('success', 'Berhasil update.');
    }

    // MASSAL
    public function bulkValidate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:logbooks,id',
            'status' => 'required|in:approved,rejected',
        ]);

        $this->getLogbookBaseQuery()
            ->whereIn('id', $request->ids)
            ->update([
                'status' => $request->status
            ]);

        if ($request->wantsJson() || $request->header('Accept') == 'application/json') {
            return response()->json([
                'message' => count($request->ids) . ' logbook berhasil di-' . $request->status,
            ]);
        }

        return redirect()->back()->with('success', 'Logbook berhasil divalidasi massal.');
    }

    /**
     * 3. Menampilkan rekap aktivitas yang sudah diproses
     */
    public function recap()
    {
        $recap = $this->getLogbookBaseQuery()
            ->with(['student.user'])
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->get();

        return view('industry.logbooks.recap', compact('recap'));
    }

    public function downloadDocument($id)
    {
        $logbook = $this->getLogbookBaseQuery()->findOrFail($id);

        if (!$logbook->documentation_file) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        return Storage::disk('public')->download($logbook->documentation_file);
    }
}