<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lawyer extends Model
{
    use HasFactory;
    public function services()
    {
        return $this->belongsToMany(Service::class, "service_lawyers");
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function university()
    {
        return $this->belongsTo(University::class);
    }
    public function news()
    {
        return $this->hasMany(News::class);
    }
}
