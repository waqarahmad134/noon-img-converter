<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieManagement extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'status',
        'youtube',
        'rumble',
        'storyfire',
        'abyss',
        'vidhide',
        'streamwish',
        'vidguard',
        'uploadFrom',
    ];
}
