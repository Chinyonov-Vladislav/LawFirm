<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseService extends Model
{
    use HasFactory;
    protected $table="case_services";
    protected $fillable = [
        "instance_id",
        "service_lawyer_id"
    ];
    public function service_lawyer()
    {
        return $this->belongsTo(ServiceLawyer::class);
    }
    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }
}
