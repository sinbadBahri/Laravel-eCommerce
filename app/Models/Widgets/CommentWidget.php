<?php

namespace App\Models\Widgets;

use App\Models\Blog\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentWidget extends Model
{
    use HasFactory;

    protected $table = 'comment_widgets';

    protected $fillable = ['title', 'is_active'];


    public function comments()
    {

        return $this->belongsToMany
        (
            related: Comment::class,
            table: 'comments_widgets_relations',
        );

    }

    /**
     * This method returns only the main comments of a specific post.
     * Does not include the reply comments related to that posts.
     *
     * @param string $post_id
     * @return array
     */
    public function getOrphanComments(string $post_id)
    {

        $allComments = $this->getAllPostComments(post_id: $post_id);
        $orphanComments = [];

        foreach ($allComments as $comment)
        {

            if($comment->parent == null)
            {
                array_push($orphanComments, $comment);
            }
        }

        return $orphanComments;

    }

    /**
     * Returns the number of total comments related to a specific post.
     * Includes both main comments and replies.
     *
     * @param string $post_id
     * @return int
     */
    public function getCommentsQuantity(string $post_id): int
    {

        $allComments = $this->getAllPostComments(post_id: $post_id);
        return count($allComments);

    }

    /**
     * returns all the comments of a specific posts.
     * regarding the ones that have parent the ones that have not.
     *
     * @param string $post_id
     * @return mixed
     */
    private function getAllPostComments(string $post_id)
    {

        return $this->comments
                    ->where('post_id', $post_id)
                    ->all();

    }

}
