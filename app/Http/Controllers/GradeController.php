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
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['owner', 'mentor'])) {
            abort(403, 'Unauthorized action.');
        }

        $userIndustryId = $user->role === 'mentor' ? ($user->mentor->industry_id ?? null) : $user->industry_id;

        $query = School::where('industry_id', $userIndustryId);

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $school = $userIndustryId ? $query->get() : collect();

        return view('industry.grades.index', compact('school'));
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

        if (!in_array($user->role, ['owner', 'mentor']) || $school->industry_id !== $user->industry_id) {
            abort(403, 'Unauthorized action.');
        }

        $students = Student::with('grades')->where('school_id', $school->id)->get();
        return view('industry.grades.show', compact('students', 'school'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school, Student $student)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['owner', 'mentor']) || $school->industry_id !== $user->industry_id) {
            abort(403, 'Unauthorized action.');
        }

        $criterion = \App\Models\Criterion::where('school_id', $school->id)->get();

        foreach ($criterion as $crit) {
            $gradeExists = Grade::where('student_id', $student->id)
                ->where('criteria_id', $crit->id)
                ->exists();

            if (!$gradeExists) {
                Grade::create([
                    'student_id' => $student->id,
                    'criteria_id' => $crit->id,
                    'score' => 0,
                ]);
            }
        }

        $grades = Grade::where('student_id', $student->id)->get();

        return view('industry.grades.edit', compact('student', 'criterion', 'grades', 'school'));
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
