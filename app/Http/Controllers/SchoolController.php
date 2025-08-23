<?php

namespace App\Http\Controllers;

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
        // Deny access for non-owner roles.
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }

        $schools = School::where('industry_id', $user->industry->id)->get();

        return view('schools.management', compact('schools'));
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

        $schools = School::where('industry_id', $user->industry->id)->get();

        return view('schools.index', compact('schools'));
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

        return view('schools.create', compact('industry'));
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
        $validatedData['industry_id'] = $user->industry->id;

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
        if ($user->role !== 'owner' || $school->industry_id !== $user->industry->id) {
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
        if ($user->role !== 'owner' || $school->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('schools.edit', compact('school'));
    }

    /**
     * Update the specified school in storage.
     */
    public function update(UpdateSchoolRequest $request, School $school)
    {
        $user = Auth::user();
        // Deny access if user is not an owner or the school is not in their industry.
        if ($user->role !== 'owner' || $school->industry_id !== $user->industry->id) {
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
        if ($user->role !== 'owner' || $school->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }

        $school->delete();

        return redirect()->route('schools.index')->with('success', 'Sekolah berhasil dihapus.');
    }
}
