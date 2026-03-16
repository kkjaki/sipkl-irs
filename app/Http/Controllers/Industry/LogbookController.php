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
        $logbooks = Logbook::with(['student.user', 'student.school'])
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
        $logbook = Logbook::with(['student.user'])->findOrFail($id);
        return view('industry.logbooks.edit', compact('logbook'));
    }

    public function validateLogbook(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,revision',
            'feedback' => 'nullable|string'
        ]);

        $logbook = \App\Models\Logbook::findOrFail($id);
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

        \App\Models\Logbook::whereIn('id', $request->ids)->update([
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
        $recap = Logbook::with(['student.user'])
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->get();

        return view('industry.logbooks.recap', compact('recap'));
    }
}
