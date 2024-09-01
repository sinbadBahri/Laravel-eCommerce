<?php

namespace App\Models\Blog;

use App\Models\User;
use App\Models\Widgets\CommentWidget;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;


    protected $table = 'post_comments';
    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'content',
    ] ;


    public function children()
    {
    
        return $this->hasMany(Comment::class, 'parent_id');
    
    }

    public function parent()
    {
    
        return $this->belongsTo(Comment::class, 'parent_id');
    
    }

    public function nestedParents()
    {
    
        $parents = $this->parent()->get();
        

        $nestedParents = $parents->flatMap(function ($parent) {

            $ancestors = collect();
            echo $ancestors;

            while ($parent) {
                $ancestors->push($parent);
                $parent = $parent->parent;
            }
    
            return $ancestors;
        
        });

        return $nestedParents->unique('id');
        
    }

    public function nestedChildren()
    {
        $children = $this->children()->get();
    
        $nestedChildren = $children->flatMap(function ($child) {
    
            # Create a collection to hold the current child and its descendants
            $descendants = collect([$child]);
    
            # Recursively add all the child's children to the collection
            if ($child->children()->exists()) {
                $descendants = $descendants->merge($child->nestedChildren());
            }
    
            return $descendants;
        });
    
        # Ensure all comments are unique by ID
        return $nestedChildren->unique('id');
    }

    public function user()
    {

        return $this->belongsTo(User::class,'user_id');
        
    }

    public function post()
    {

        return $this->belongsTo(Post::class,'post_id');
        
    }

    public function widgets()
    {

        return $this->belongsToMany
        (
            related: CommentWidget::class,
            table: 'comments_widgets_relations',
        );
        
    }

    private function getCategoryWithAncestors(Comment $comment)
    {

        $ancestors = collect();

        // Recursively gather parent categories
        while ($comment) {
            $ancestors->push($comment);
            $comment = $comment->parent;
        }

        return $ancestors;
    
    }

}
