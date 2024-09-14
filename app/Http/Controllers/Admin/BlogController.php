<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog\Post;

class BlogController extends Controller
{
    
    public function postsList()
    {

        $blogPosts = Post::all();
        return view(view: 'admin.blog.postList', data: compact('blogPosts'));
        
    }

    public function create()
    {
        return view(view: 'admin.forms.postForm');
    }
}
