<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Support\Footer;
use App\Support\Navbar;
use Illuminate\Http\Request;

class PostController extends Controller
{

    protected $footer;

    protected $navbar;


    public function __construct(Footer $footer, Navbar $navbar)
    {
    
        $this->footer = $footer;
        $this->navbar = $navbar;
    
    }

    public function show()
    {

        # Navbar
        $cartItems = $this->navbar->cartItems;
        $genres = $this->navbar->genres;

        # Footer
        $footerCollection = $this->footer->getAllFooterItems();

        $content = [
            # Navbar
            'cartItems',
            'genres',

            # Footer
            'footerCollection',
        ];

        return view("post.single", compact($content));
        
    }

}
