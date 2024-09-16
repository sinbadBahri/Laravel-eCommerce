<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['title'] ;


    public function posts()
    {

        return $this->belongsToMany
        (
            related: Post::class,
            table: "genre_post_relations",
        );
        
    }

}
