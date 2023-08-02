<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NunoMaduro\Collision\Adapters\Phpunit\State;

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
    public $timestamps = false;

    public function continent()
    {
        return $this->belongsTo(Continents::class,'continent_id');
    }

    public function states(){
        return $this->hasMany(States::class,'state_id');
    }
}
