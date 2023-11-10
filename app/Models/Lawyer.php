<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lawyer extends Model
{
    use HasFactory;
    protected $table="lawyers";

    protected $fillable = [
        "first_name",
        "second_name",
        "middle_name",
        "hire_date",
        "images",
        "number_phone",
        'university_id',
        'user_id',
        "level_education",
    ];
    protected $casts = [
        'images' => 'array',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, "service_lawyers")->withPivot('cost');
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

    public function service_lawyer()
    {
        return $this->hasMany(ServiceLawyer::class);
    }
}
