<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class Countries extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;
    protected $fillable = [
        'short_code',
        'name',
        'timezone',
        'phone_code',
        'continent_id'
    ];

    public static function boot(): void
    {
        parent::boot();
        static::deleted(function($table){
            $table->states()->delete();
        });
    }

    public function continents()
    {
        return $this->belongsTo(Continents::class,'continent_id');
    }

    public function states()
    {
        return $this->hasMany(States::class,'country_id');
    }
}
