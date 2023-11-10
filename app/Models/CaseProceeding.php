<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseProceeding extends Model
{
    protected $table = "case_proceedings";
    use HasFactory;

    protected $fillable = [
        "start_date",
        "finish_date",
        "judge_id",
        "instance_id",
        "court_stage_id"
    ];

    public function court_stage()
    {
        return $this->belongsTo(CourtStage::class);
    }

    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }

    public function judge()
    {
        return $this->belongsTo(Judge::class);
    }
}
