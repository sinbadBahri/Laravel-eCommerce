<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Support\Master\Footer;
use App\Support\Master\Navbar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{

    protected $footer;
    protected $navbar;


    public function __construct(Footer $footer, Navbar $navbar)
    {
        
        $this->footer = $footer;
        $this->navbar = $navbar;

    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        
        # Navbar
        $cartItems = $this->navbar->getCartTotal();
        $genres = $this->navbar->genres;
        
        # Body
        $user = $request->user();

        # Footer
        $footerCollection = $this->footer->getAllFooterItems();

        $content = [
            # Navbar
            'cartItems',
            'genres',

            # Body 
            'user',

            # Footer
            'footerCollection',
        ];
        
        return view('profile.edit', compact($content));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
