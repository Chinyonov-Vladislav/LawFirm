<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOutcome extends Model
{
    use HasFactory;
    protected $table="type_outcomes";
    protected $fillable = [
        "name"
    ];
    public function instances()
    {
        return $this->belongsToMany(Instance::class);
    }
}
