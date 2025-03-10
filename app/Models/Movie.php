<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    // protected $fillable = ['title','description','slug'];
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_movie')->withTimestamps()->withPivot([]);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'actor_movie');
    }

    public function actresses()
    {
        return $this->belongsToMany(Actress::class, 'actress_movie');
    }

    public function qualities()
    {
        return $this->belongsToMany(Quality::class, 'quality_movie');
    }

    public function types()
    {
        return $this->belongsToMany(Type::class, 'type_movie');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_movie');
    }

    public function south_actor()
    {
        return $this->belongsToMany(SouthActor::class, 'south_actor_movie');
    }

    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'season_movie');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    
}
