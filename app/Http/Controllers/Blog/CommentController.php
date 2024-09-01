<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\Comment;
use App\Models\Widgets\CommentWidget;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentController extends Controller
{
    
    /**
     * Creates a new Blog\Comment instance with the given parametters.
     * Also makes sure the new comment is included in the Comment Widget.
     * 
     * After storing the data redirects the user to the previous page.
     * 
     * @param string $id
     * @param string $comment_id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(string $id, string $comment_id, Request $request)
    {

        $comment = Comment::create([
                    'user_id' => JWTAuth::user()->id,
                    'post_id' => $id,
                    'parent_id' => $this->getParentId($comment_id),
                    'content' => $request->comment,
                    ]);

        $this->addCommentToWidget(comment: $comment);

        return redirect()->back()->with('success','201');
        
    }

    /**
     * Considers if the new comment is nested or has no parent_id.
     * 
     * @param string $parent_id
     * @return string|null
     */
    private function getParentId(string $parent_id)
    {

        if ($parent_id == "empty")
        {
            return null;
        }
        
        return $parent_id;
        
    }

    /**
     * This method creates a new many-to-many relationship between
     * the post_comments table and the comment_widgets if the comment doesn't have a parent.
     * 
     * By default the name of comment_widget defined as "main".
     * Do not change the default value if it's not necessary.
     * 
     * @param string $widget_title
     * @param Comment $comment
     * @return void
     */
    private function addCommentToWidget(Comment $comment, string $widget_title = "main")
    {

        # Check if the comment doesn't have a parent (no parent_id)
        if (is_null($comment->parent_id)) {
            
            $widget = CommentWidget::where('title', $widget_title)->first();
    
            # If the widget doesn't exist, create it
            if (!$widget) {
                $widget = CommentWidget::create([
                    'title' => $widget_title,
                    'is_active' => true,
                ]);
            }
    
            $comment->widgets()->attach($widget->id);

        }        
    }

}
