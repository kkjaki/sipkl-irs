<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

    /*
    |--------------------------------------------------------------------------
    | LANDING
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {
        return view('landing-student');
    })->name('landing');


    /*
    |--------------------------------------------------------------------------
    | AUTH
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return view('dashboard-student');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | PRESENSI
    |--------------------------------------------------------------------------
    */

    Route::get('/presensi', function () {
        return view('student.presensi.index');
    })->name('presensi.index');

    Route::get('/presensi/create', function () {
        return view('student.presensi.create');
    })->name('presensi.create');

    Route::post('/presensi', function (Request $request) {

        $request->validate([
            'bukti_presensi' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal' => 'required|date'
        ]);

        // simpan foto
        $path = $request->file('bukti_presensi')->store('presensi','public');

        return back()->with('success','Presensi berhasil disimpan. File: '.$path);

    })->name('presensi.store');


    /*
    |--------------------------------------------------------------------------
    | LOGBOOK
    |--------------------------------------------------------------------------
    */

    Route::get('/logbook', function () {
        return view('student.logbook.index');
    })->name('logbook.index');

    Route::get('/logbook/create', function () {
        return view('student.logbook.create');
    })->name('logbook.create');

    Route::post('/logbook', function (Request $request) {

        $request->validate([
            'deskripsi' => 'required',
            'pendamping' => 'required',
            'dokumentasi' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240'
        ]);

        // simpan file dokumentasi
        $path = $request->file('dokumentasi')->store('logbook','public');

        return back()->with('success','Logbook berhasil disimpan. File: '.$path);

    })->name('logbook.store');


    Route::get('/logbook/{id}/edit', function ($id) {
        return view('student.logbook.edit');
    })->name('logbook.edit');

    Route::put('/logbook/{id}', function ($id) {
        return back()->with('success','Logbook berhasil diupdate');
    })->name('logbook.update');


    /*
    |--------------------------------------------------------------------------
    | NILAI
    |--------------------------------------------------------------------------
    */

    Route::get('/nilai', function () {
        return view('student.nilai.index');
    })->name('nilai.index');

    Route::get('/nilai/print', function () {
        return view('student.nilai.print');
    })->name('nilai.print');


    /*
    |--------------------------------------------------------------------------
    | PROFIL
    |--------------------------------------------------------------------------
    */

    Route::get('/profil', function () {
        return view('student.profil.index');
    })->name('profil.index');

    Route::put('/profil', function () {
        return back()->with('success','Profil berhasil diperbarui!');
    })->name('profil.update');

});


/*
|--------------------------------------------------------------------------
| DASHBOARD DEFAULT
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class,'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';