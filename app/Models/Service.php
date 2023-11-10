<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table="services";
    protected $fillable = [
        "name",
        "specialization_id"
    ];
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
    public function lawyers()
    {
        return $this->belongsToMany(Lawyer::class, "service_lawyers");
    }
}
