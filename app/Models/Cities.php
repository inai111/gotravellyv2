<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'state_id',
        'lat',
        'lng'
    ];
    public $timestamps = false;

    public function state()
    {
        return $this->belongsTo(States::class,'state_id');
    }
}
