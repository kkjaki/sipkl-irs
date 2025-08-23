<?php

namespace App\Http\Controllers;
use App\Models\Mentor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;


class MentorController extends BaseController
{
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
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.'); // Deny access for non-owner roles
        }
        $mentors = Mentor::where('industry_id', $user->industry->id)->with('user')->get(); // Fetch mentors in the same industry as the owner
        return view('mentors.index', compact('mentors'));
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
        $industry = $user->industry; // The user has a `hasOne` industry relationship
        return view('mentors.create', compact('industry')); // Return the view with the industry data
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.'); // Deny access for non-owner roles
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'position' => 'required|string|max:255',
        ]);

        // Create the user
        $newUser = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => 'mentor', // Assign the role as mentor
        ]);

        // Create the mentor record
        Mentor::create([
            'user_id' => $newUser->id,
            'industry_id' => $user->industry->id, // Assign the industry of the owner creating the mentor
            'position' => $validatedData['position'],
        ]);

        return redirect()->route('mentors.index')->with('success', 'Mentor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mentor $mentor)
    {
        // Not typically used for nested resources, the index view serves as the list.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mentor $mentor)
    {
        $user = Auth::user();
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.'); // Deny access for non-owner roles
        }
        $industry = $user->industry; // The user has a `hasOne` industry relationship
        return view('mentors.edit', compact('mentor', 'industry')); // Return the view with mentor and the industry data
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mentor $mentor)
    {
        $user = Auth::user();
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.'); // Deny access for non-owner roles
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $mentor->user_id,
            'position' => 'required|string|max:255',
        ]);

        // Update the user
        $mentor->user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        // Update the mentor record
        $mentor->update([
            'position' => $validatedData['position'],
        ]);

        return redirect()->route('mentors.index')->with('success', 'Mentor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mentor $mentor)
    {
        $user = Auth::user();
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.'); // Deny access for non-owner roles
        }
        // Delete the mentor record and the associated user
        $mentor->delete();
        $mentor->user->delete();

        return redirect()->route('mentors.index')->with('success', 'Mentor deleted successfully.');
    }

    public function deactive(Mentor $mentor)
    {
        $user = Auth::user();
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.'); // Deny access for non-owner roles
        }
        // Deactivate the mentor
        $mentor->user->update(['is_active' => false]);
        $mentor->user->save();
        return redirect()->route('mentors.index')->with('success', 'Mentor deactivated successfully.');
    }
    
    public function active(Mentor $mentor)
    {
        $user = Auth::user();
        if ($user->role !== 'owner') {
            abort(403, 'Unauthorized action.'); // Deny access for non-owner roles
        }
        // Activate the mentor
        $mentor->user->update(['is_active' => true]);
        $mentor->user->save();
        return redirect()->route('mentors.index')->with('success', 'Mentor activated successfully.');
    }
}
