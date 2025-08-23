<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolSupervisor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class SchoolSupervisorController extends BaseController
{
    /**
     * Apply authentication middleware.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the supervisors for a specific school.
     */
    public function index(School $school)
    {
        $this->authorizeManagement($school);

        $supervisors = $school->schoolSupervisors()->orderBy('name')->get();

        return view('supervisors.index', compact('school', 'supervisors'));
    }

    /**
     * Show the form for creating a new supervisor for a specific school.
     */
    public function create(School $school)
    {
        $this->authorizeManagement($school);

        return view('supervisors.create', compact('school'));
    }

    /**
     * Store a newly created supervisor in storage.
     */
    public function store(Request $request, School $school)
    {
        $this->authorizeManagement($school);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $school->schoolSupervisors()->create($request->all());

        return redirect()->route('schools.supervisors.index', $school)
            ->with('success', 'Data guru pembimbing berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * Note: This method is not typically used for this resource.
     */
    public function show(SchoolSupervisor $supervisor)
    {
        // Intentionally left blank.
    }

    /**
     * Show the form for editing the specified supervisor.
     */
    public function edit(SchoolSupervisor $supervisor)
    {
        $this->authorizeManagement($supervisor->school);

        return view('supervisors.edit', compact('supervisor'));
    }

    /**
     * Update the specified supervisor in storage.
     */
    public function update(Request $request, SchoolSupervisor $supervisor)
    {
        $this->authorizeManagement($supervisor->school);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $supervisor->update($request->all());

        return redirect()->route('schools.supervisors.index', $supervisor->school)
            ->with('success', 'Data guru pembimbing berhasil diperbarui.');
    }

    /**
     * Remove the specified supervisor from storage.
     */
    public function destroy(SchoolSupervisor $supervisor)
    {
        $this->authorizeManagement($supervisor->school);

        $school = $supervisor->school;
        $supervisor->delete();

        return redirect()->route('schools.supervisors.index', $school)
            ->with('success', 'School supervisor deleted successfully.');
    }

    /**
     * Helper method to authorize management of school resources.
     */
    private function authorizeManagement(School $school)
    {
        $user = Auth::user();
        // Deny access if user is not an owner or the school is not in their industry.
        if (! $user || $user->role !== 'owner' || $school->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
