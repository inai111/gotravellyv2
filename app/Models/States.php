<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class States extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'country_id',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::deleted(function($table){
            $table->cities()->delete();
        });
    }

    public $timestamps = false;

    public function countries()
    {
        return $this->belongsTo(Countries::class,'country_id');
    }

    public function cities()
    {
        return $this->hasMany(Cities::class,'state_id');
    }

}
