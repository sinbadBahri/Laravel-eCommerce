<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function store(Request $request): RedirectResponse
    {
        
        // dd($request);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        # Configuring the Admin State
        $user->is_admin = $request->is_admin == "on" ?? true;
        $user->save();

        event(new Registered(user: $user));

        return redirect(route("users"))->with("success","New User Added");
    }
}
