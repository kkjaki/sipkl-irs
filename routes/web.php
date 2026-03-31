<?php

use App\Http\Controllers\Industry\AttendanceController;
use App\Http\Controllers\Industry\AttendanceSessionController;
use App\Http\Controllers\Industry\AttendanceValidationController;
use App\Http\Controllers\Industry\CriterionController;
use App\Http\Controllers\Industry\DashboardController;
use App\Http\Controllers\Industry\GradeController;
use App\Http\Controllers\Industry\InternshipProgramController;
use App\Http\Controllers\Industry\LogbookController as IndustryLogbookController;
use App\Http\Controllers\Industry\MentorController;
use App\Http\Controllers\Industry\RecapController;
use App\Http\Controllers\Industry\SchoolController;
use App\Http\Controllers\Industry\SchoolSupervisorController;
use App\Http\Controllers\Auth\StudentRegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\AttendanceController as StudentAttendanceController;
use App\Http\Controllers\Student\LogbookController as StudentLogbookController;
use App\Http\Controllers\Student\GradeController as StudentGradeController;
use App\Http\Controllers\Student\StudentSetupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // SHARED ROUTES (Owner & Mentor)
    Route::middleware(['role:owner,mentor'])->group(function () {
        Route::get('/schools/management', [SchoolController::class, 'management'])->name('schools.management');
        Route::patch('/attendance-sessions/{attendanceSession}/close', [AttendanceSessionController::class, 'close'])->name('attendance-sessions.close');
        Route::resource('attendance-sessions', AttendanceSessionController::class);

        Route::controller(AttendanceController::class)->group(function () {
            Route::get('/attendance-sessions/{session}/validate', 'show')->name('attendance.validate.show');
            Route::put('/attendance-sessions/{session}/validate', 'update')->name('attendance.validate.update');
        });

        // Validasi Presensi (Owner) List Sekolah
        Route::get('/attendance-validation', [AttendanceValidationController::class, 'index'])->name('attendance.validate.schools.index');
        Route::get('/attendance-validation/{school}', [AttendanceValidationController::class, 'show'])->name('attendance.validate.schools.show');

        // Grades
        Route::group(['prefix' => 'grades/schools'], function () {
            Route::controller(GradeController::class)->group(function () {
                Route::get('/', 'index')->name('grades.schools.index');
                Route::get('/{school}', 'show')->name('grades.schools.show');
                Route::get('/{school}/student/{student}', 'edit')->name('grades.schools.edit');
                Route::put('/{school}/student/{student}', 'update')->name('grades.schools.update');
            });
        });

        // Industry Logbook API Routes
        Route::prefix('industry')->name('industry.')->group(function () {
            Route::get('/logbooks', [IndustryLogbookController::class, 'index'])->name('logbooks.index');
            Route::get('/logbooks/{id}/edit', [IndustryLogbookController::class, 'edit'])->name('logbooks.edit');
            Route::get('/logbooks/{id}/download', [IndustryLogbookController::class, 'downloadDocument'])->name('logbooks.download');
            Route::patch('/logbooks/{id}/validate', [IndustryLogbookController::class, 'validateLogbook'])->name('logbooks.validate');
            Route::patch('/logbooks/bulk-validate', [IndustryLogbookController::class, 'bulkValidate'])->name('logbooks.bulk_validate');
            Route::get('/logbooks/recap', [IndustryLogbookController::class, 'recap'])->name('logbooks.recap');
            Route::get('/recap', [RecapController::class, 'index'])->name('recap.index');
        });

        // Shared School Management
        Route::resource('schools.supervisors', SchoolSupervisorController::class)->except(['show'])->shallow();
        Route::resource('schools.criteria', CriterionController::class)->except(['show'])->shallow();
    });

    // OWNER EXCLUSIVE ROUTES
    Route::middleware(['role:owner'])->group(function () {
        Route::resource('schools', SchoolController::class);
        Route::resource('mentors', MentorController::class)->except(['show']);
        Route::post('mentors/{mentor}/deactivate', [MentorController::class, 'deactivate'])->name('mentors.deactivate');
        Route::post('mentors/{mentor}/activate', [MentorController::class, 'activate'])->name('mentors.activate');
        Route::resource('internship-programs', InternshipProgramController::class);

        Route::get('/industry', function () {
            return view('industry.dashboard.index');
        })->name('industry');
    });

    // Student routes
    Route::middleware(['is.student'])->prefix('student')->name('student.')->group(function () {

        // Onboarding Setup
        Route::get('/setup', [StudentSetupController::class, 'create'])->name('setup');
        Route::post('/setup', [StudentSetupController::class, 'store'])->name('setup.store');

        Route::middleware(['profile.completed'])->group(function () {
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
    });
});

Route::get('csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
})->name('csrf-token');

// Student Landing Page
Route::get('/student/landing', function () {
    return view('landing-student');
})->name('student.landing');

// Student Registration
Route::get('register/student', [StudentRegistrationController::class, 'create'])->name('student.register');
Route::post('register/student', [StudentRegistrationController::class, 'store'])->name('student.register.store');

require __DIR__ . '/auth.php';
