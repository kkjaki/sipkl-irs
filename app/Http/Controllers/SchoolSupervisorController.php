<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolSupervisor;
use Illuminate\Http\Request;

class SchoolSupervisorController extends Controller
{
    /**
     * Display a listing of the resource for a specific school.
     */
    public function index(School $school)
    {
        $supervisors = $school->schoolSupervisors()->orderBy('name')->get();
        return view('supervisors.index', compact('school', 'supervisors'));
    }

    /**
     * Show the form for creating a new resource for a specific school.
     */
    public function create(School $school)
    {
        return view('supervisors.create', compact('school'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, School $school)
    {
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
     */
    public function show(SchoolSupervisor $schoolSupervisor)
    {
        // Not typically used for nested resources, the index view serves as the list.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolSupervisor $supervisor)
    {
        return view('supervisors.edit', compact('supervisor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolSupervisor $supervisor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);
        $supervisor->update($request->all());

        return redirect()->route('schools.supervisors.index', $supervisor->school)
            ->with('success', 'Data guru pembimbing berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolSupervisor $supervisor)
    {
        $school = $supervisor->school;
        $supervisor->delete();

        return redirect()->route('schools.supervisors.index', $school)
            ->with('success', 'Data guru pembimbing berhasil dihapus.');
    }
}
