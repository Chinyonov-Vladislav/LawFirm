<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourtStage extends Model
{
    use HasFactory;
    public function case_proceedings()
    {
        return $this->hasMany(CaseProceeding::class);
    }
}
