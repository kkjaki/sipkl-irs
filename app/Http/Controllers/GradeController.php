<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGradeRequest;
use App\Models\Criterion;
use App\Models\Grade;
use App\Models\School;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if (!in_array($user->role, ['owner', 'mentor'])) {
            abort(403, 'Unauthorized action.');
        }

        $school = School::where('industry_id', $user->industry->id)->get();

        return response()->json($school);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['owner', 'mentor'])) {
            abort(403, 'Unauthorized action.');
        }

        $students = Student::where('school_id', $school->id)->get();
        return response()->json($students);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school, Student $student)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['owner', 'mentor'])) {
            abort(403, 'Unauthorized action.');
        }

        $grades = Grade::where('student_id', $student->id)->get();
        $criterion = \App\Models\Criterion::where('school_id', $school->id)->get();
        return response()->json([
            'student' => $student,
            'criterion' => $criterion,
            'grades'  => $grades,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school, Student $student)
    {
        $validated = $request->validate([
            'grades' => 'required|array',
            'grades.*.id' => 'required|exists:grades,id',
            'grades.*.score' => 'required|numeric|min:0|max:100',
        ]);

        foreach ($validated['grades'] as $gradeData) {
            \App\Models\Grade::where('id', $gradeData['id'])
                ->where('student_id', $student->id) 
                ->update(['score' => $gradeData['score']]);
        }

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Semua penilaian berhasil disimpan sekaligus!',
        //     'data' => $validated['grades']
        // ]);
        return redirect()->back()->with('success', 'Nilai berhasil diperbarui!');
    }
}
