<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\School;
use Illuminate\Support\Facades\Auth;

use Illuminate\Routing\Controller as BaseController;

class SchoolController extends BaseController
{
    /**
     * Constructor to apply middleware.
     */
    public function __construct()
    {
        // Redirects to login page if user is not authenticated.
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'owner') {
            $schools = School::where('industry_id', $user->industry->id)->get();
        } else {
            abort(403, 'Unauthorized action.'); // Deny access for non-owner roles
        }

        return view('schools.index', compact('schools')); // Return the view with schools data
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->role === 'owner') {
            // Allow only owners to create schools
            $industries = $user->industries; // Assuming the user has an industry relationship

            return view('schools.create', compact('industries'));
        } else {
            abort(403, 'Unauthorized action.'); // Deny access for non-owner roles
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolRequest $request)
    {
        $validatedData = $request->validated();
        // Create a new school record
        School::create($validatedData);

        // Redirect or return a response
        return redirect()->route('schools.index')->with('success', 'School created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        // Ensure the owner can only see schools in their industry
        $user = Auth::user();
        if ($user->role !== 'owner' || $school->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('schools.show', compact('school'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        // Ensure the owner can only edit schools in their industry
        $user = Auth::user();
        if ($user->role !== 'owner' || $school->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('schools.edit', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchoolRequest $request, School $school)
    {
        $validatedData = $request->validated();

        // Update the school record
        $school->update($validatedData);

        // Redirect or return a response
        return redirect()->route('schools.index')->with('success', 'School updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        // Ensure the owner can only delete schools in their industry
        $user = Auth::user();
        if ($user->role !== 'owner' || $school->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the school record
        $school->delete();

        // Redirect or return a response
        return redirect()->route('schools.index')->with('success', 'School deleted successfully.');
    }
}
