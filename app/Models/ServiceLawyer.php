<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceLawyer extends Model
{
    use HasFactory;
    protected $table="service_lawyers";
    protected $fillable = [
        'service_id',
        'lawyer_id',
        "cost"
    ];
    public function instances()
    {
        return $this->belongsToMany(Instance::class);
    }
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }
    public function case_services()
    {
        return $this->hasMany(CaseService::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
