<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'peace_value_id',
        'level',
        'description',
        'source',
        'active',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function peaceValue()
    {
        return $this->belongsTo(PeaceValue::class, 'peace_value_id');
    }
}
