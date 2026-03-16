<?php

namespace App\Http\Controllers\Industry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Student;

class RecapController extends Controller
{
    public function index(Request $request)
    {
        $schools = School::orderBy('name')->get();

        $query = Student::with(['user', 'school'])
            ->withCount([
                'attendances as hadir_count' => function ($q) {
                    $q->where('status', 'hadir');
                },
                'attendances as izin_count' => function ($q) {
                    $q->where('status', 'izin');
                },
                'attendances as sakit_count' => function ($q) {
                    $q->where('status', 'sakit');
                },
                'attendances as alpa_count' => function ($q) {
                    $q->where('status', 'alpa');
                },
                'logbooks as pending_count' => function ($q) {
                    $q->where('status', 'pending');
                },
                'logbooks as approved_count' => function ($q) {
                    $q->where('status', 'approved');
                },
                'logbooks as rejected_count' => function ($q) {
                    $q->where('status', 'rejected');
                }
            ]);

        if ($request->filled('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        $students = $query->paginate(12)->withQueryString();

        return view('industry.recap.index', compact('students', 'schools'));
    }
}
