<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handles the incoming authentication request.
     * 
     * If the credentials were correct, a Json Web Token would be created.
     * This Token then would be saved as a Cookie.
     * 
     */
    public function store(LoginRequest $request)#: RedirectResponse
    {

        $credentials = request(['email', 'password']);

        if (! $token = auth('web')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // dd($this->respondWithToken($token));

        # Set the token as a cookie
        return redirect()->intended(route('dashboard'))->cookie(
        'token', # Cookie name
        $token,  # Token value
        auth('web')->factory()->getTTL() * 60, # Expiration in minutes
        '/',    # Path
        null,   # Domain (null for default)
        true,   # Secure (true for HTTPS)
        true    # HttpOnly
        );
    }

    /**
     * Destroy an authenticated Cookie and erase the Bearer Token.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $cookie = Cookie::forget('token');

        return redirect('/')->withCookie($cookie);
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('web')->factory()->getTTL() * 60
        ]);
    }

}
