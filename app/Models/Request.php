<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $table="requests";
    protected $fillable = [
        "topic",
        "description",
        "date_request",
        "status",
        'client_id'
    ];

    public function Instance()
    {
        return $this->hasOne(Request::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
