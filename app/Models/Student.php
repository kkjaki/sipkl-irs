<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'internship_program_id',
        'industry_id',
        'school_id',
        'school_supervisor_id',
        'nis',
        'class',
        'address',
        'phone',
        'hobby',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * Get the user account associated with the student.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the internship program the student is enrolled in.
     */
    public function internshipProgram(): BelongsTo
    {
        return $this->belongsTo(InternshipProgram::class);
    }

    /**
     * Get the industry the student belongs to based on the program
     */
    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    /**
     * Get all grades for the student.
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Get a single attendance record for the student.
     */
    public function attendance(): HasOne
    {
        return $this->hasOne(Attendance::class);
    }

    /**
     * Get the school the student belongs to.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the school supervisor guiding the student.
     */
    public function schoolSupervisor(): BelongsTo
    {
        return $this->belongsTo(SchoolSupervisor::class);
    }

    /**
     * Get all attendances for the student.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get all logbooks for the student.
     */
    public function logbooks(): HasMany
    {
        return $this->hasMany(Logbook::class);
    }
}
