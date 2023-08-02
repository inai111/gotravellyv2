<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_id',
    ];

    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo(Countries::class,'country_id');
    }

    public function cities()
    {
        return $this->hasMany(Cities::class,'state_id');
    }

}
