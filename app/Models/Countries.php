<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_code',
        'name',
        'timezone',
        'phone_code',
        'continent_id'
    ];
    protected $timestamps = false;
}
