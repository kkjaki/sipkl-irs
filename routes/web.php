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
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\AttendanceController as StudentAttendanceController;
use App\Http\Controllers\Student\LogbookController as StudentLogbookController;
use App\Http\Controllers\Student\GradeController as StudentGradeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Industry\LogbookController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->role === 'student') {
        return redirect()->route('student.dashboard');
    }
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

    Route::controller(AttendanceSessionController::class)->group(function () {
        Route::get('/attendance-sessions', 'index')->name('attendance-sessions.index');
        Route::post('/attendance-sessions', 'store')->name('attendance-sessions.store');
        Route::patch('/attendance-sessions/{attendanceSession}/close', [AttendanceSessionController::class, 'close'])->name('attendanceSessions.close');
    });

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

   

    // Student routes
    Route::middleware(['auth', 'is.student'])->prefix('student')->name('student.')->group(function () {
        Route::get('/', [StudentDashboardController::class, 'index'])->name('dashboard');

        // Attendance routes
        Route::controller(StudentAttendanceController::class)->group(function () {
            Route::get('/presensi/harian', 'presensiHarian')->name('presensi.harian');
            Route::post('/presensi', 'store')->name('presensi.store');
            Route::get('/presensi/daftar', 'index')->name('presensi.index');
        });

        // Logbook routes
        Route::controller(StudentLogbookController::class)->group(function () {
            Route::get('/logbook/harian', 'logbookHarian')->name('logbook.harian');
            Route::post('/logbook', 'store')->name('logbook.store');
            Route::get('/logbook/daftar', 'index')->name('logbook.index');
            Route::get('/logbook/{id}/edit', 'edit')->name('logbook.edit');
            Route::put('/logbook/{id}', 'update')->name('logbook.update');
        });

        // Grades routes
        Route::controller(StudentGradeController::class)->group(function () {
            Route::get('/nilai', 'index')->name('nilai.index');
            Route::get('/nilai/download', 'downloadPdf')->name('nilai.download');
        });
    });

    Route::get('/industry', function () {
        return view('industry.dashboard');
    })->name('industry');
});

Route::get('csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
})->name('csrf-token');

// Student Registration
Route::get('register/student', [StudentRegistrationController::class, 'create'])->name('student.register');
Route::post('register/student', [StudentRegistrationController::class, 'store']);

require __DIR__ . '/auth.php';

 // Industry/Owner
    Route::prefix('industry')->name('industry.')->group(function () {
    Route::get('/logbooks', [LogbookController::class, 'index'])->name('logbooks.index');
    // Route Individu
    Route::patch('/logbooks/{id}/validate', [LogbookController::class, 'validateLogbook'])->name('logbooks.validate');
    // Route Massal
    Route::patch('/logbooks/bulk-validate', [LogbookController::class, 'bulkValidate'])->name('logbooks.bulk_validate');
    Route::get('/logbooks/recap', [LogbookController::class, 'recap'])->name('logbooks.recap');
});
