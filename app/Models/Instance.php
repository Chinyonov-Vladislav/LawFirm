<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    use HasFactory;
    public function judges()
    {
        return $this->belongsToMany(Judge::class, "case_proceedings");
    }
    public function types_outcome()
    {
        return $this->belongsToMany(TypeOutcome::class);
    }
    public function service_lawyers()
    {
        return $this->belongsToMany(ServiceLawyer::class);
    }
}
