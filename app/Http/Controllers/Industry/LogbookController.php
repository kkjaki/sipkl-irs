<?php

namespace App\Http\Controllers\Industry;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogbookController extends Controller
{
    /**
     * 1. Mengambil data logbook yang perlu divalidasi
     * Sesuai panah: getLogbook()
     */
    public function index()
    {
        $user = auth()->user();
        $userIndustryId = $user->role === 'mentor' ? ($user->mentor->industry_id ?? null) : $user->industry_id;

        $logbooks = Logbook::whereHas('student', function ($query) use ($userIndustryId) {
                $query->where('industry_id', $userIndustryId);
            })
            ->with(['student.user', 'student.school'])
            ->latest()
            ->paginate(30);
            
        return view('industry.logbooks.index', compact('logbooks'));
    }

    /**
     * 2. Memproses validasi (Approve atau Reject)
     * Sesuai panah: validateLogbook(status)
     */
    //  INDIVIDU 
    public function edit($id)
    {
        $user = auth()->user();
        $userIndustryId = $user->role === 'mentor' ? ($user->mentor->industry_id ?? null) : $user->industry_id;

        $logbook = Logbook::whereHas('student', function ($query) use ($userIndustryId) {
                $query->where('industry_id', $userIndustryId);
            })
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

        $user = auth()->user();
        $userIndustryId = $user->role === 'mentor' ? ($user->mentor->industry_id ?? null) : $user->industry_id;

        $logbook = \App\Models\Logbook::whereHas('student', function ($query) use ($userIndustryId) {
                $query->where('industry_id', $userIndustryId);
            })->findOrFail($id);

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

        $user = auth()->user();
        $userIndustryId = $user->role === 'mentor' ? ($user->mentor->industry_id ?? null) : $user->industry_id;
        
        \App\Models\Logbook::whereIn('id', $request->ids)
            ->whereHas('student', function ($query) use ($userIndustryId) {
                $query->where('industry_id', $userIndustryId);
            })
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
     * Sesuai panah: getStudentActivityRecap()
     */
    public function recap()
    {
        $user = auth()->user();
        $userIndustryId = $user->role === 'mentor' ? ($user->mentor->industry_id ?? null) : $user->industry_id;

        $recap = Logbook::whereHas('student', function ($query) use ($userIndustryId) {
                $query->where('industry_id', $userIndustryId);
            })
            ->with(['student.user'])
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->get();

        return view('industry.logbooks.recap', compact('recap'));
    }

    public function downloadDocument($id)
    {
        $user = auth()->user();
        $userIndustryId = $user->role === 'mentor' ? ($user->mentor->industry_id ?? null) : $user->industry_id;

        $logbook = Logbook::whereHas('student', function ($query) use ($userIndustryId) {
                $query->where('industry_id', $userIndustryId);
            })->findOrFail($id);

        if (!$logbook->documentation_file) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        return Storage::disk('public')->download($logbook->documentation_file);
    }
}
