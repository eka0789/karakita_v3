<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Assessment;
use App\Models\Classroom;
use App\Models\Recommendation;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable;

    /**
     * Kolom yang bisa diisi mass-assignment
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'birth_date',
        'address',
        'parent_id',
        'classroom_id',
        'photo',
    ];

    /**
     * Hidden fields
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Data casting otomatis
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'photo' => 'string',
    ];

    /**
     * ======================
     * RELATIONSHIPS
     * ======================
     */

    // Rekomendasi untuk siswa
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'student_id');
    }

    // Semua penilaian sebagai siswa
    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'student_id');
    }

    // Penilaian yang diberikan oleh guru/orangtua
    public function givenAssessments()
    {
        return $this->hasMany(Assessment::class, 'assessor_id');
    }

    // Ambil penilaian terbaru
    public function latestAssessment()
    {
        return $this->hasOne(Assessment::class, 'student_id')->latest('assessed_at');
    }

    // Relasi orang tua → anak-anak
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    // Relasi siswa → orang tua
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    // Relasi siswa → kelas
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}
