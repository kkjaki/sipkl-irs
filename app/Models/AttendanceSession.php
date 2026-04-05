<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttendanceSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry_id',
        'school_id', // Pastikan kolom ini ada di database lo ya
        'opened_by_user_id',
        'session_date',
        'on_time_deadline',
        'closed_at',
        'is_open',
    ];

    protected $casts = [
        'is_open' => 'boolean',
    ];

    /**
     * Relasi ke User yang membuka sesi
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_by_user_id', 'id');
    }

    /**
     * Relasi ke Industri
     */
    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    /**
     * Relasi ke Sekolah (Krusial buat halaman Validasi)
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Relasi ke Data Kehadiran Siswa
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'attendance_session_id');
    }
}