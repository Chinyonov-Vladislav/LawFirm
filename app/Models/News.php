<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table="news";
    protected $fillable = [
        "title",
        "description",
        "images",
        'lawyer_id'
    ];
    protected $casts = [
        'images' => 'array',
    ];
    public function Lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }
    public function getLastThreeNews()
    {
        return $this->with("Lawyer")->latest()->take(3)->get();
    }
}
