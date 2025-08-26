<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\InternshipProgram;
use App\Models\User;
use App\Models\Student;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class StudentRegistrationController extends Controller
{
    /**
     * Display the student registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.student-register');
    }

    /**
     * Handle an incoming student registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'invitation_code' => ['required', 'string'],
        ]);

        $internshipProgram = InternshipProgram::where('invitation_code', $request->invitation_code)->where('is_active', true)->first();

        if (!$internshipProgram) {
            return back()->withErrors(['invitation_code' => 'Kode Undangan tidak valid atau sudah tidak berlaku.']);
        }

        DB::transaction(function () use ($request, $internshipProgram) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Student::create([
                'user_id' => $user->id,
                'internship_program_id' => $internshipProgram->id,
                // 'student_id' => null,
            ]);
        });

        return redirect('/login')->with('status', 'Registrasi berhasil! Silakan login.');
    }
}
