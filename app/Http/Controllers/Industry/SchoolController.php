<?php

namespace App\Http\Controllers\Industry;

use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\School;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class SchoolController extends BaseController
{
    /**
     * Apply authentication middleware.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the school management page for an industry owner.
     */
   public function management()
{
    $user = Auth::user();
    
    if (!in_array($user->role, ['owner', 'mentor'])) {
        abort(403, 'Unauthorized action.');
    }

    $industryId = $user->industry_id;

    if (!$industryId) {
        return view('industry.schools.management', ['schools' => collect()]);
    }

    // JIKA OWNER: Liat semua sekolah di industrinya
    if ($user->role === 'owner') {
        $schools = School::where('industry_id', $industryId)->get();
    } 
    // 🔥 JIKA MENTOR (TANU): Cuma sekolah yang ada murid bimbingannya dia
    else {
        $schools = School::where('industry_id', $industryId)
            ->whereHas('students.internshipProgram', function ($query) use ($user) {
                $query->where('mentor_id', $user->mentor->id);
            })->get();
    }

    return view('industry.schools.management', compact('schools'));
}

    /**
     * Display a listing of the schools for an industry owner.
     */
    public function index()
    {
        $user = Auth::user();
        // Deny access for non-owner roles.
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }

        $schools = $user->industry_id ? School::where('industry_id', $user->industry_id)->get() : collect();

        return view('industry.schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new school.
     */
    public function create()
    {
        $user = Auth::user();
        // Deny access for non-owner roles.
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }

        $industry = $user->industry;

        return view('industry.schools.create', compact('industry'));
    }

    /**
     * Store a newly created school in storage.
     */
    public function store(StoreSchoolRequest $request)
    {
        $user = Auth::user();

        // Deny access for non-owner roles.
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }
        $validatedData = $request->validated();
        // Assign the industry_id from the authenticated owner's industry.
        $validatedData['industry_id'] = $user->industry_id;

        School::create($validatedData);

        return redirect()->route('schools.index')->with('success', 'Sekolah berhasil ditambahkan.');
    }

    /**
     * Display the specified school.
     */
    public function show(School $school)
    {
        $user = Auth::user();
        // Deny access if user is not an owner or the school is not in their industry.
        if ($user->role !== 'owner' || $school->industry_id !== $user->industry_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('schools.show', compact('school'));
    }

    /**
     * Show the form for editing the specified school.
     */
    public function edit(School $school)
    {
        $user = Auth::user();
        // Deny access if user is not an owner or the school is not in their industry.
        if ($user->role !== 'owner' || $school->industry_id !== $user->industry_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('industry.schools.edit', compact('school'));
    }

    /**
     * Update the specified school in storage.
     */
    public function update(UpdateSchoolRequest $request, School $school)
    {
        $user = Auth::user();
        // Deny access if user is not an owner or the school is not in their industry.
        if ($user->role !== 'owner' || $school->industry_id !== $user->industry_id) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validated();
        $school->update($validatedData);

        return redirect()->route('schools.index')->with('success', 'Sekolah berhasil diperbarui.');
    }

    /**
     * Remove the specified school from storage.
     */
    public function destroy(School $school)
    {
        $user = Auth::user();
        // Deny access if user is not an owner or the school is not in their industry.
        if ($user->role !== 'owner' || $school->industry_id !== $user->industry_id) {
            abort(403, 'Unauthorized action.');
        }

        $school->delete();

        return redirect()->route('schools.index')->with('success', 'Sekolah berhasil dihapus.');
    }
}
