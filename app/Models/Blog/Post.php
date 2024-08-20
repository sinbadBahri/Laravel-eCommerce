<?php

namespace App\Models\Blog;

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

    public function getGenre(): string
    {

        $genres = "";

        foreach ($this->genres as $genre)
        {

            $genres .= ", {$genre->title}";

        }

        return $genres;
        
    }

    public function widgets()
    {

        return $this->belongsToMany
        (
            related: PostWidget::class,
            table: "posts_widgets_relations",
        );
        
    }

}
