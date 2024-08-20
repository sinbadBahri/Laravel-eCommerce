<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [] ;


    public function comments()
    {

        return $this->hasMany(Comment::class);
        
    }

    public function genres()
    {

        return $this->belongsToMany
        (
            related: Genre::class,
            table: "genre_post_relations",
        );
        
    }

}
