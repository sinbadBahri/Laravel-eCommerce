<?php

namespace App\Support\Master;

use App\Models\Blog\Genre;
use App\Models\Cart;

class Navbar
{

    public $cartItems;

    public $genres;

    public function __construct()
    {

        $this->cartItems = $this->getCartTotal();;
        $this->genres = Genre::all();
    }

    private function getCartTotal()
    {

        $cartItems = 0;

        if (Cart::exists())
        {

            // $cart_id = TmpCart::where('user_id', auth()->id())->id;  # If we have already defined the authentication system.
            $cart_id = Cart::first()->id;
            $cartItems = Cart::getTotalQuantity(cart_id:$cart_id);

        }

        return $cartItems;

    }
    
}