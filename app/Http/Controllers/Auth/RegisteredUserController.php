<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\InternshipProgram;
use App\Models\School;
use App\Models\SchoolSupervisor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $schools = School::all();

        return view('auth.register', compact('schools'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'school_id' => ['nullable', 'exists:schools,id'],
            'invitation_code' => ['required', 'string', 'max:255', 'exists:internship_programs,invitation_code'],
        ]);

        $internshipProgramId = InternshipProgram::where('invitation_code', $request->invitation_code)->first()->id;
        $schoolSupervisor = SchoolSupervisor::where('school_id', $request->school_id)->first()?->id;
        if (!$schoolSupervisor) {
            return back()->withErrors(['school_id' => 'Supervisor untuk sekolah ini tidak ditemukan. Silakan hubungi administrator.'])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Student::create([
            'user_id' => $user->id,
            'school_id' => $request->school_id,
            'internship_program_id' => $internshipProgramId,
            'school_supervisor_id' => $schoolSupervisor,
        ]);

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
