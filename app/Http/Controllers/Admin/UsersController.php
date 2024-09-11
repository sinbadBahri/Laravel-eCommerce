<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index()
    {
        return view(view: 'admin.users.allUsers');
    }
    
    public function create()
    {

        return view(view: 'admin.forms.userForm');
        
    }
}
