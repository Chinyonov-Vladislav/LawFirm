<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Judge extends Model
{
    use HasFactory;

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
    public function instances()
    {
        return $this->belongsToMany(Instance::class, "case_proceedings");
    }
}
