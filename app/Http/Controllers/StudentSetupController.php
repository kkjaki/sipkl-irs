<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentSetupController extends Controller
{
    /**
     * Tampilkan halaman Setup Onboarding
     */
    public function create()
    {
        $user = Auth::user();

        // Cek kembali, jika ternyata nis sudah terisi, tidak perlu onboarding lagi
        if ($user && $user->role === 'student' && $user->student && !empty($user->student->nis)) {
            return redirect()->route('student.dashboard');
        }

        // Ambil invitation_code dari relasi program
        $invitationCode = $user->student && $user->student->internshipProgram
            ? $user->student->internshipProgram->invitation_code
            : '';

        return view('student.setup', compact('user', 'invitationCode'));
    }

    /**
     * Simpan data onboarding untuk kelengkapan KTP Siswa
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi form
        $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'nis'     => 'required|string|max:50|unique:students,nis,' . ($user->student->id ?? ''),
            'class'   => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'phone'   => 'required|string|max:20',
            'hobby'   => 'nullable|string|max:255',
        ]);

        // Sync Nama ke tabel users
        $user->update([
            'name' => $validatedData['name']
        ]);

        // Update Students Table (Kita update row yang sudah dibuat saat register)
        if ($user->student) {
            $industryId = $user->student->internshipProgram->industry_id ?? null;
            $user->student->update([
                'nis'         => $validatedData['nis'],
                'class'       => $validatedData['class'],
                'address'     => $validatedData['address'],
                'phone'       => $validatedData['phone'],
                'hobby'       => $validatedData['hobby'],
                'industry_id' => $industryId,
            ]);
        }

        return redirect()->route('student.dashboard')->with('success', 'Profil berhasil dilengkapi! Selamat datang di Dashboard PKL.');
    }
}
