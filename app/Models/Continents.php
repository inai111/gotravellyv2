<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Continents extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];
    public static function boot(): void
    {
        parent::boot();
        static::deleted(function($table){
            $table->countries()->delete();
        });
    }


    public function countries()
    {
        return $this->hasMany(Countries::class,'continent_id');
    }
}
