<?php

namespace App\Models\Widgets;

use App\Models\Blog\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostWidget extends Model
{
    use HasFactory;

    public function posts()
    {

        return $this->belongsToMany
        (
            related: Post::class,
            table: "posts_widgets_relations",
        );
        
    }

}
