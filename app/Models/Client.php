<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table="clients";
    protected $fillable = [
        "first_name",
        "second_name",
        "middle_name",
        "number_phone",
        "address",
        "birthday",
        'user_id',
        'city_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function requests()
    {
        return $this->hasMany(Request::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
