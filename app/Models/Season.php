<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'season_movie');
    }
}
