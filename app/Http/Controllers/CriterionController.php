<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class CriterionController extends BaseController
{
    /**
     * Apply authentication middleware.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the criteria for a specific school.
     */
    public function index(School $school)
    {
        $this->authorizeManagement($school);

        $criteria = $school->criteria()->orderBy('name')->get();

        return view('criteria.index', compact('criteria', 'school'));
    }

    /**
     * Show the form for crating a new criterion for a specific school.
     */
    public function create(School $school)
    {
        $this->authorizeManagement($school);

        return view('criteria.create', compact('school'));
    }

    /**
     * Store a newly created criterion in storage.
     */
    public function store(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = array_merge($validated, ['industry_id' => $school->industry_id]);

        $school->criteria()->create($data);

        return redirect()->route('schools.criteria.index', $school)
            ->with('success', 'Kriteria berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * Note: This method is not typically used for this resource.
     */
    public function show(Criterion $criterion)
    {
        // Intentionally left blank.
    }

    /**
     * Show the form for editing the specified criterion.
     */
    public function edit(Criterion $criterion)
    {
        $this->authorizeManagement($criterion->school);

        return view('criteria.edit', compact('criterion'));
    }

    /**
     * Update the specified criterion in storage.
     */
    public function update(Request $request, Criterion $criterion)
    {
        $this->authorizeManagement($criterion->school);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $criterion->update($validated);

        return redirect()->route('schools.criteria.index', $criterion->school)
            ->with('success', 'Kriteria berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criterion $criterion)
    {
        $this->authorizeManagement($criterion->school);

        $criterion->delete();

        return redirect()->route('schools.criteria.index', $criterion->school)
            ->with('success', 'Kriteria berhasil dihapus.');
    }

    /**
     * Helper method to authorize management of criterion resources.
     */
    private function authorizeManagement(School $school)
    {
        $user = Auth::user();
        // Deny access if the user is not an owner or the school is not in their industry.
        if ($user->role !== 'owner' || $school->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
