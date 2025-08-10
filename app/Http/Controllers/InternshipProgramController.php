<?php

namespace App\Http\Controllers;

use App\Models\Internship_program;
use App\Http\Requests\StoreInternshipProgramRequest;
use App\Http\Requests\UpdateInternshipProgramRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class InternshipProgramController extends BaseController
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
            // Ambil semua program magang yang dimiliki oleh industri yang dimiliki oleh user
            $internshipPrograms = Internship_program::whereHas('industry', function ($query) use ($user) {
                $query->where('owner_id', $user->id);
            })->get();
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return view('internship_programs.index', compact('internshipPrograms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.'); // Deny access for non-owner roles

        }

        // Tampilkan form untuk membuat program magang baru
        return view('internship_programs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInternshipProgramRequest $request)
    {
        $user = Auth::user();
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.'); // Deny access for non-owner roles
        }
        $validatedData = $request->validated();
        $validatedData['industry_id'] = $user->industry->id; // Set industry_id from the authenticated user's industry
        Internship_program::create($validatedData);
        return redirect()->route('internship_programs.index')->with('success', 'Program magang berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Internship_program $internship_program)
    {
        $user = Auth::user();
        // Ensure the owner can only see internship programs in their industry
        if ($user->role !== 'owner' || $internship_program->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }
        return view('internship_programs.show', compact('internship_program'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Internship_program $internship_program)
    {
        $user = Auth::user();
        // Ensure the owner can only edit internship programs in their industry
        if ($user->role !== 'owner' || $internship_program->industry_id !== $user->industry->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return view('internship_programs.edit', compact('internship_program'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInternshipProgramRequest $request, Internship_program $internship_program)
    {
        $user = Auth::user();
        // Ensure the owner can only update internship programs in their industry
        if ($user->role !== 'owner' || $internship_program->industry_id !== $user->industry->id) { // Deny access for non-owner roles
            abort(403, 'Unauthorized action.');
        }

        $internship_program->update($request->validated());
        return redirect()->route('internship_programs.index')->with('success', 'Program magang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Internship_program $internship_program)
    {
        $user = Auth::user();
        // Ensure the owner can only delete internship programs in their industry
        if ($user->role !== 'owner' || $internship_program->industry_id !== $user->industry->id) { // Deny access for non-owner roles
            abort(403, 'Unauthorized action.');
        }

        $internship_program->delete();
        return redirect()->route('internship_programs.index')->with('success', 'Program magang berhasil dihapus.');
    }
}
