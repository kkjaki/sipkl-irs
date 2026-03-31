<?php

namespace App\Http\Controllers\Industry;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Industry;
use App\Models\Student;
use App\Models\School;
use App\Models\SchoolSupervisor;
use App\Models\Mentor;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'student') {
            return redirect()->route('student.dashboard');
        }

        $user = Auth::user();
        $industry = $user->industry ?? Industry::first();

        $jumlahSiswa = 0;
        $jumlahSekolah = 0;
        $jumlahMentor = 0;
        $jumlahGuru = 0;

        if ($industry) {
            $jumlahSiswa = Student::whereHas('internshipProgram', function ($query) use ($industry) {
                $query->where('industry_id', $industry->id);
            })->count();

            $jumlahSekolah = School::where('industry_id', $industry->id)->count();
            
            $jumlahMentor = Mentor::where('industry_id', $industry->id)->count();

            $jumlahGuru = SchoolSupervisor::whereHas('school', function ($query) use ($industry) {
                $query->where('industry_id', $industry->id);
            })->count();
        }

        return view('industry.dashboard.index', compact('industry', 'jumlahSiswa', 'jumlahSekolah', 'jumlahMentor', 'jumlahGuru'));
    }
}
