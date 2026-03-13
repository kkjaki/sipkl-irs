<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;
use PDF;

class GradeController extends Controller
{
    /**
     * Display the student's grades.
     */
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        // Get grades with criteria information
        $grades = Grade::where('student_id', $student->id)
            ->with('criterion')
            ->orderBy('id')
            ->get();

        // Calculate statistics
        $totalScore = $grades->sum('score');
        $averageScore = $grades->count() > 0 ? $grades->avg('score') : 0;
        $highestScore = $grades->max('score') ?? 0;
        $lowestScore = $grades->min('score') ?? 0;
        $gradeCount = $grades->count();

        // Grade categories
        $excellentCount = $grades->where('score', '>=', 90)->count();
        $goodCount = $grades->whereBetween('score', [80, 89])->count();
        $fairCount = $grades->whereBetween('score', [70, 79])->count();
        $poorCount = $grades->where('score', '<', 70)->count();

        return view('student.grades', compact(
            'grades',
            'student',
            'totalScore',
            'averageScore',
            'highestScore',
            'lowestScore',
            'gradeCount',
            'excellentCount',
            'goodCount',
            'fairCount',
            'poorCount'
        ));
    }

    /**
     * Download grades as PDF.
     */
    public function downloadPdf()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        // Get grades with criteria information
        $grades = Grade::where('student_id', $student->id)
            ->with('criterion')
            ->orderBy('id')
            ->get();

        // Calculate statistics
        $totalScore = $grades->sum('score');
        $averageScore = $grades->count() > 0 ? $grades->avg('score') : 0;
        $gradeCount = $grades->count();

        $data = [
            'student' => $student,
            'user' => $user,
            'grades' => $grades,
            'totalScore' => $totalScore,
            'averageScore' => $averageScore,
            'gradeCount' => $gradeCount,
            'date' => now()->format('d F Y'),
        ];

        // Generate PDF
        $pdf = PDF::loadView('student.grades-pdf', $data);

        // Download PDF
        $fileName = 'nilai_' . str_replace(' ', '_', strtolower($user->name)) . '_' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($fileName);
    }
}
