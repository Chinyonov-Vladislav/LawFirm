<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;
    protected $table="specializations";
    protected $fillable = [
        "name",
        "description",
        "icon"
    ];
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function getAllSpecializations()
    {
        return $this->all();
    }
}
