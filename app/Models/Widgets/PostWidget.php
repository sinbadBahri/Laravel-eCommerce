<?php

namespace App\Models\Widgets;

use App\Models\Blog\Genre;
use App\Models\Blog\Post;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * Get a single post by its ID from the widget's posts.
     *
     * @param string $id The ID of the post to retrieve.
     * @return mixed The first post matching the given ID.
     */
    public function getSinglePost(string $id)
    {

        return $this->posts->where("id", $id)->first();
        
    }

    /**
     * Get a specified number of posts randomly ordered.
     *
     * @param int $number The number of posts to retrieve.
     * @return Collection The collection of randomly ordered posts.
     */
    public function getSomePosts(int $number)
    {

        return $this->posts()->inRandomOrder()->take($number)->get();
        
    }

    /**
     * Get posts associated with a specific genre.
     *
     * If the $genre_id is null, returns all posts.
     * Otherwise, retrieves the genre using the $genre_id, 
     * fetches all posts with that genre, and returns the common posts 
     * between the widget's posts and the genre's posts.
     *
     * @param int|null $genre_id The ID of the genre to filter posts by.
     * @return Collection The collection of posts with the specified genre.
     */
    public function getPostsWithGenre($genre_id)
    {
        
        if ($genre_id == null)
        {
            return $this->posts;
        }

        $genre = Genre::find($genre_id);
        $allPostsWithGenre = $genre->posts;

        return $this->findCommonPosts($allPostsWithGenre);
        
    }

    /**
     * Finds common posts between the current widget's posts and a given post collection.
     *
     * @param Collection $postCollection The collection of posts to compare with the widget's posts
     * @return Collection The common posts shared between the widget's posts and the given post collection
     */
    private function findCommonPosts(Collection $postCollection)
    {
        # Extract post IDs from each collection
        $idsOfPostCollection = $postCollection->pluck("id")->toArray();
        $idsOfWidgetPosts = $this->posts->pluck("id")->toArray();

        # Find common post IDs
        $commonIds = array_intersect($idsOfWidgetPosts, $idsOfPostCollection);

        # Retrieve the common posts
        $commonPosts = Post::whereIn("id", $commonIds)->get();

        return $commonPosts;
        
    }

}
