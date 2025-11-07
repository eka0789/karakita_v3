<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeaceValue extends Model
{
    protected $fillable = ['name','order'];
    public function indicators() { return $this->hasMany(Indicator::class); }
}
