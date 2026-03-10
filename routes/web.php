<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| LANDING
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| STUDENT ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('student')->name('student.')->group(function () {

    Route::get('/', function () {
        return view('landing-student');
    })->name('landing');

    // LOGIN
    Route::get('/login', function () {
        return view('auth.login-student');
    })->name('login');

    Route::post('/login', function () {
        return redirect()->route('student.dashboard');
    })->name('login.store');

    // REGISTER
    Route::get('/register', function () {
        return view('auth.register-student');
    })->name('register');

    Route::post('/register', function () {
        return redirect()->route('student.dashboard');
    })->name('register.store');

    // DASHBOARD
    Route::get('/dashboard', function () {
        return view('dashboard-student');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | PRESENSI SISWA
    |--------------------------------------------------------------------------
    */

    Route::get('/industry/kehadiran', function () {
        return view('industry.student.presensi.index');
    })->name('kehadiran.index');

    Route::get('/industry/kehadiran/create', function () {
        return view('industry.student.presensi.create');
    })->name('kehadiran.create');

    Route::post('/industry/kehadiran', function () {
        //
    })->name('kehadiran.store');


    /*
    |--------------------------------------------------------------------------
    | LOGBOOK SISWA
    |--------------------------------------------------------------------------
    */

    Route::get('/industry/logbook', function () {
        return view('industry.student.logbook.index');
    })->name('logbook.index');

    Route::get('/industry/logbook/create', function () {
        return view('industry.student.logbook.create');
    })->name('logbook.create');

    Route::post('/industry/logbook', function () {
        return "Data berhasil disimpan";
    })->name('logbook.store');

    Route::get('/industry/logbook/{id}/edit', function ($id) {
        return view('industry.student.logbook.edit');
    })->name('logbook.edit');

    Route::put('/industry/logbook/{id}', function ($id) {
        return "Data berhasil diupdate";
    })->name('logbook.update');

    Route::get('/industry/logbook/{id}', function ($id) {
        return view('industry.student.logbook.show');
    })->name('logbook.show');

    Route::delete('/industry/logbook/{id}', function ($id) {
        return "Data berhasil dihapus";
    })->name('logbook.destroy');


    /*
    |--------------------------------------------------------------------------
    | NILAI SISWA  ✅ PINDAH KE DALAM GROUP
    |--------------------------------------------------------------------------
    */

    Route::get('/industry/nilai', function () {
        return view('industry.student.nilai.index');
    })->name('nilai.index');

    Route::get('/industry/nilai/print', function () {
        return view('industry.student.nilai.print');
    })->name('nilai.print');

        /*
    |--------------------------------------------------------------------------
    | PROFILE SISWA
    |--------------------------------------------------------------------------
    */

    Route::get('/industry/profil', function () {
        return view('industry.student.profil.index');
    })->name('profil.index');

    Route::put('/industry/profil', function () {
    return back()->with('success', 'Profil berhasil diperbarui!');
})->name('profil.update');


});


/*
|--------------------------------------------------------------------------
| DASHBOARD (DEFAULT)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
