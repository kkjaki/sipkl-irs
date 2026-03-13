<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceSessionController;
use App\Http\Controllers\Auth\StudentRegistrationController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\GradeController;
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
    Route::resource('schools.criteria', CriterionController::class)->except(['show'])->shallow();
    Route::resource('mentors', MentorController::class)->except(['show']);
    Route::post('mentors/{mentor}/deactivate', [MentorController::class, 'deactivate'])->name('mentors.deactivate');
    Route::post('mentors/{mentor}/activate', [MentorController::class, 'activate'])->name('mentors.activate');
    Route::resource('internship-programs', InternshipProgramController::class);

    Route::patch('/attendance-sessions/{attendanceSession}/close', [AttendanceSessionController::class, 'close'])->name('attendance-sessions.close');
    Route::resource('attendance-sessions', AttendanceSessionController::class);

    Route::controller(AttendanceController::class)->group(function () {
        Route::get('/attendance-sessions/{session}/validate', 'show')->name('attendance.validate.show');
        Route::put('/attendance-sessions/{session}/validate', 'update')->name('attendance.validate.update');
    });

    Route::group(['prefix' => 'grades/schools'], function () {
        Route::controller(GradeController::class)->group(function () {
            Route::get('/', 'index')->name('grades.schools.index');
            Route::get('/{school}', 'show')->name('grades.schools.show');
            Route::get('/{school}/student/{student}', 'edit')->name('grades.schools.edit');
            Route::put('/{school}/student/{student}', 'update')->name('grades.schools.update');
        });
    });

    Route::middleware(['role:owner'])->group(function () {
        Route::get('/industry', function () {
            return view('industry.dashboard');
        })->name('industry');
    });
});

Route::get('csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
})->name('csrf-token');

// Student Registration
Route::get('register/student', [StudentRegistrationController::class, 'create'])->name('student.register');
Route::post('register/student', [StudentRegistrationController::class, 'store']);

require __DIR__ . '/auth.php';
