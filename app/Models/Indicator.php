<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'peace_value_id',
        'description',
        'scale_min',
        'scale_max',
    ];

    public function peaceValue()
    {
        return $this->belongsTo(PeaceValue::class, 'peace_value_id');
    }
}
