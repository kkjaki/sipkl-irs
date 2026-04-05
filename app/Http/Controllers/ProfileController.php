<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Industry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * UPDATE KHUSUS DATA INDUSTRI (Untuk Role Owner)
     * Sesuai permintaan: Update Nama PT, Alamat, dan Kordinat GPS
     */

    public function updateIndustry(Request $request): RedirectResponse {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'nullable|string|max:20',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);
        
        $user = auth()->user();

        if($user->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }

        Industry::updateOrCreate(
            ['owner_id' => $user->id],
            [
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]
        );
        return Redirect::route('profile.edit')->with('status', 'industry-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
