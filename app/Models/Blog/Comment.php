<?php

namespace App\Models\Blog;

use App\Models\User;
use App\Models\Widgets\CommentWidget;
use Illuminate\Support\Collection;
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

    /**
     * Returns all the parents of of the parent.
     * 
     * @return Collection Comment Collection which includes all the parents of the Comment instance.
     */
    public function nestedParents()
    {
    
        $parents = $this->parent()->get();
        

        $nestedParents = $parents->flatMap(function ($parent) {

            $ancestors = collect();

            while ($parent) {
                $ancestors->push($parent);
                $parent = $parent->parent;
            }
    
            return $ancestors;
        
        });

        return $nestedParents->unique('id');
        
    }

    /**
     * Returns all the children of the children.
     * 
     * @return Collection Comment Collection which includes all the children of the Comment instance.
     */
    public function nestedChildren(): Collection
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

}
