<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'assessor_id',
        'source',
        'class_name',
        'assessed_at',
        'note',
    ];

    // ✅ Tambahkan casting ke tanggal
    protected $casts = [
        'assessed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function assessor()
    {
        return $this->belongsTo(User::class, 'assessor_id');
    }

    public function scores()
    {
        return $this->hasMany(AssessmentScore::class);
    }
}
