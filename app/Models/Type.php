<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status'];
    protected $hidden = ['pivot'];

    
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'type_movie');
    }
}
