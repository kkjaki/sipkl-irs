<?php

use App\Http\Controllers\InternshipProgramController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SchoolSupervisorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/schools/management', [SchoolController::class, 'management'])->name('schools.management');
    Route::resource('schools', SchoolController::class);
    Route::resource('schools.supervisors', SchoolSupervisorController::class)->except(['show'])->shallow();
    Route::resource('mentors', MentorController::class)->except(['show']);
    Route::post('mentors/{mentor}/deactivate', [MentorController::class, 'deactivate'])->name('mentors.deactivate');
    Route::post('mentors/{mentor}/activate', [MentorController::class, 'activate'])->name('mentors.activate');
    Route::resource('internshipPrograms', InternshipProgramController::class);
});

require __DIR__.'/auth.php';
