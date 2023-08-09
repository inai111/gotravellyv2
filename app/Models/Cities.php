<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cities extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'state_id',
        'lat',
        'lng'
    ];

    public static function boot(): void
    {
        parent::boot();
        static::deleted(function($table){
            $table->states()->delete();
        });
    }



    public function states()
    {
        return $this->belongsTo(States::class,'state_id');
    }
}
