<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    
    public function postsList()
    {

        return view(view: 'admin.blog.postList');
        
    }

    public function create()
    {
        return view(view: 'admin.forms.postForm');
    }
}
