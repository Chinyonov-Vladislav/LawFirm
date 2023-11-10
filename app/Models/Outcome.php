<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    use HasFactory;
    protected $table="outcomes";
    protected $fillable = [
        'type_outcome_id',
        'instance_id',
        "monetary_penalty",
        "count_years"
    ];
}
