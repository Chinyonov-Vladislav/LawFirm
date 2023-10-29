<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function courts()
    {
        return $this->hasMany(Court::class);
    }
    public function universities()
    {
        return $this->hasMany(University::class);
    }
    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
