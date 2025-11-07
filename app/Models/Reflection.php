<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reflection extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'content',
    ];

    // Relasi ke siswa
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
