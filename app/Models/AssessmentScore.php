<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentScore extends Model
{
    protected $fillable = ['assessment_id','indicator_id','score'];
    public $timestamps = false;

    public function indicator() { return $this->belongsTo(Indicator::class); }
    public function assessment()
{
    return $this->belongsTo(Assessment::class);
}

}
