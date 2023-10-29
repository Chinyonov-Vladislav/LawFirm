<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;
    protected $fillable = [
        "name_court",
        'address',
        'number_phone',
        'city_id'
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function judges()
    {
        return $this->hasMany(Judge::class);
    }
}
