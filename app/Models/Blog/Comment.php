<?php

namespace App\Models\Blog;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;


    protected $table = 'post_comments';
    protected $fillable = [] ;


    public function children()
    {
    
        return $this->hasMany(Comment::class, 'parent_id');
    
    }

    public function parent()
    {
    
        return $this->belongsTo(Comment::class, 'parent_id');
    
    }

    public function user()
    {

        return $this->belongsTo(User::class,'user_id');
        
    }

    public function post()
    {

        return $this->belongsTo(Post::class,'post_id');
        
    }

}
