<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view(view: 'admin.users.allUsers', data: compact('users'));
    }
    
    public function create()
    {

        return view(view: 'admin.forms.userForm');
        
    }
}
