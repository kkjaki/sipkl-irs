<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class MentorController extends BaseController
{
    /**
     * Apply authentication middleware.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of mentors for the owner's industry.
     */
    public function index()
    {
        $user = Auth::user();
        // Deny access for non-owner roles.
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }
        // Fetch mentors in the same industry as the owner.
        $mentors = Mentor::where('industry_id', $user->industry->id)->with('user')->get();

        return view('mentors.index', compact('mentors'));
    }

    /**
     * Show the form for creating a new mentor.
     */
    public function create()
    {
        $user = Auth::user();
        // Deny access for non-owner roles.
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }
        $industry = $user->industry;

        return view('mentors.create', compact('industry'));
    }

    /**
     * Store a newly created mentor in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        // Deny access for non-owner roles.
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'position' => 'required|string|max:255',
        ]);

        // Create a new user for the mentor.
        $newUser = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => 'mentor',
        ]);

        // Create the mentor record, linking it to the new user and owner's industry.
        Mentor::create([
            'user_id' => $newUser->id,
            'industry_id' => $user->industry->id,
            'position' => $validatedData['position'],
        ]);

        return redirect()->route('mentors.index')->with('success', 'Mentor berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * Note: This method is not typically used as the index view serves as the primary list.
     */
    public function show(Mentor $mentor)
    {
        // Intentionally left blank.
    }

    /**
     * Show the form for editing the specified mentor.
     */
    public function edit(Mentor $mentor)
    {
        $user = Auth::user();
        // Deny access if user is not an owner or the mentor is not in their industry.
        if ($user->role !== 'owner' || $mentor->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }
        $industry = $user->industry;

        return view('mentors.edit', compact('mentor', 'industry'));
    }

    /**
     * Update the specified mentor in storage.
     */
    public function update(Request $request, Mentor $mentor)
    {
        $user = Auth::user();
        // Deny access if user is not an owner or the mentor is not in their industry.
        if ($user->role !== 'owner' || $mentor->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$mentor->user_id,
            'position' => 'required|string|max:255',
        ]);

        // Update the associated user record.
        $mentor->user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        // Update the mentor's position.
        $mentor->update([
            'position' => $validatedData['position'],
        ]);

        return redirect()->route('mentors.index')->with('success', 'Mentor berhasil diperbarui.');
    }

    /**
     * Remove the specified mentor from storage.
     */
    public function destroy(Mentor $mentor)
    {
        $user = Auth::user();
        // Deny access if user is not an owner or the mentor is not in their industry.
        if ($user->role !== 'owner' || $mentor->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }

        // The associated user record is deleted automatically by the model's deleting event.
        $mentor->delete();

        return redirect()->route('mentors.index')->with('success', 'Mentor berhasil dihapus.');
    }

    /**
     * Deactivates the specified mentor's account.
     */
    public function deactivate(Mentor $mentor)
    {
        $user = Auth::user();
        // Deny access if user is not an owner or the mentor is not in their industry.
        if ($user->role !== 'owner' || $mentor->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }

        // Deactivate the mentor's user account.
        $mentor->user->update(['is_active' => false]);

        return redirect()->route('mentors.index')->with('success', 'Mentor berhasil dinonaktifkan.');
    }

    /**
     * Activates the specified mentor's account.
     */
    public function activate(Mentor $mentor)
    {
        $user = Auth::user();
        // Deny access if user is not an owner or the mentor is not in their industry.
        if ($user->role !== 'owner' || $mentor->industry_id !== $user->industry->id) {
            abort(403, 'Unauthorized action.');
        }

        // Activate the mentor's user account.
        $mentor->user->update(['is_active' => true]);

        return redirect()->route('mentors.index')->with('success', 'Mentor berhasil diaktifkan.');
    }
}
