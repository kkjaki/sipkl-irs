<?php

namespace App\Http\Controllers\Industry;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    /**
     * 1. Mengambil data logbook yang perlu divalidasi
     * Sesuai panah: getLogbook()
     */
    public function index()
    {
        $user = auth()->user();
        $logbooks = Logbook::whereHas('student', function ($query) use ($user) {
                $query->where('industry_id', $user->industry_id);
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
        $logbook = Logbook::whereHas('student', function ($query) use ($user) {
                $query->where('industry_id', $user->industry_id);
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
        $logbook = \App\Models\Logbook::whereHas('student', function ($query) use ($user) {
                $query->where('industry_id', $user->industry_id);
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
        
        \App\Models\Logbook::whereIn('id', $request->ids)
            ->whereHas('student', function ($query) use ($user) {
                $query->where('industry_id', $user->industry_id);
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
        $recap = Logbook::whereHas('student', function ($query) use ($user) {
                $query->where('industry_id', $user->industry_id);
            })
            ->with(['student.user'])
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->get();

        return view('industry.logbooks.recap', compact('recap'));
    }
}
