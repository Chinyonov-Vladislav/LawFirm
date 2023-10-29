<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseProceeding extends Model
{
    use HasFactory;
    public function court_stage()
    {
        return $this->belongsTo(CourtStage::class);
    }
}
