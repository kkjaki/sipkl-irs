<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInternshipProgramRequest;
use App\Http\Requests\UpdateInternshipProgramRequest;
use App\Models\InternshipProgram;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class InternshipProgramController extends BaseController
{
    /**
     * Apply authentication middleware.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the internship programs.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'owner') {
            // Retrieve all internship programs associated with the owner's industry.
            $internshipPrograms = InternshipProgram::whereHas('industry', function ($query) use ($user) {
                $query->where('owner_id', $user->id);
            })->get();
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return view('internshipPrograms.index', compact('internshipPrograms'));
    }

    /**
     * Show the form for creating a new internship program.
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }

        // Show the form to create a new internship program.
        return view('internshipPrograms.create');
    }

    /**
     * Store a newly created internship program in storage.
     */
    public function store(StoreInternshipProgramRequest $request)
    {
        $user = Auth::user();
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validated();
        // Set industry_id from the authenticated user's industry.
        $validatedData['industry_id'] = $user->industry->id;
        // Generate a random 6-character invitation code.
        $validatedData['invitation_code'] = \Illuminate\Support\Str::random(6);
        InternshipProgram::create($validatedData);

        return redirect()->route('internshipPrograms.index')->with('success', 'Program magang berhasil dibuat.');
    }

    /**
     * Display the specified internship program.
     */
    public function show(InternshipProgram $internshipProgram)
    {
        $user = Auth::user();
        // Ensure the owner can only view internship programs in their industry.
        if ($user->role !== 'owner' || $internshipProgram->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('internshipPrograms.show', compact('internshipProgram'));
    }

    /**
     * Show the form for editing the specified internship program.
     */
    public function edit(InternshipProgram $internshipProgram)
    {
        $user = Auth::user();
        // Ensure the owner can only edit internship programs in their industry.
        if ($user->role !== 'owner' || $internshipProgram->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('internshipPrograms.edit', compact('internshipProgram'));
    }

    /**
     * Update the specified internship program in storage.
     */
    public function update(UpdateInternshipProgramRequest $request, InternshipProgram $internshipProgram)
    {
        $user = Auth::user();
        // Ensure the owner can only update internship programs in their industry.
        if ($user->role !== 'owner' || $internshipProgram->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }

        $internshipProgram->update($request->validated());

        return redirect()->route('internshipPrograms.index')->with('success', 'Program magang berhasil diperbarui.');
    }

    /**
     * Remove the specified internship program from storage.
     */
    public function destroy(InternshipProgram $internshipProgram)
    {
        $user = Auth::user();
        // Ensure the owner can only delete internship programs in their industry.
        if ($user->role !== 'owner' || $internshipProgram->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }

        $internshipProgram->delete();

        return redirect()->route('internshipPrograms.index')->with('success', 'Program magang berhasil dihapus.');
    }
}
