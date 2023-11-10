<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    use HasFactory;
    protected $table="instances";
    protected $fillable = [
        "start_date",
        "end_date",
        "status",
        "feedback",
        "rating",
        "request_id"
    ];
    public function judges()
    {
        return $this->belongsToMany(Judge::class, "case_proceedings");
    }
    public function types_outcome()
    {
        return $this->belongsToMany(TypeOutcome::class,'outcomes')->withPivot(["monetary_penalty","count_years"]);
    }
    public function service_lawyers()
    {
        return $this->belongsToMany(ServiceLawyer::class, "case_services","service_lawyer_id","instance_id" );
    }
    public function case_services()
    {
        return $this->hasMany(CaseService::class);
    }
    public function request()
    {
        return $this->belongsTo(Request::class);
    }
    public function case_proceeding()
    {
        return $this->hasMany(CaseProceeding::class);
    }
}
