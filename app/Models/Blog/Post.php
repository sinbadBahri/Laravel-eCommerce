<?php

namespace App\Models\Blog;

use App\Models\Images\PostImage;
use App\Models\Widgets\PostWidget;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Laravel\Prompts\table;

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

    public function widgets()
    {

        return $this->belongsToMany
        (
            related: PostWidget::class,
            table: "posts_widgets_relations",
        );
        
    }

    public function images()
    {

        return $this->hasMany(related:PostImage::class);
        
    }

}
