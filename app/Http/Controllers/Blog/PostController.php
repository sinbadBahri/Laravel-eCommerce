<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Widgets\PostWidget;
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

    public function show(string $id)
    {

        # Navbar
        $cartItems = $this->navbar->cartItems;
        $genres = $this->navbar->genres;

        # Body Widgets
        $singlePost = $this->getPostWidget("single", $id);

        # Footer
        $footerCollection = $this->footer->getAllFooterItems();

        $content = [
            # Navbar
            'cartItems',
            'genres',

            # Body Widgets
            'singlePost',

            # Footer
            'footerCollection',
        ];

        return view("post.single", compact($content));
        
    }

    private function getPostWidget(string $widgetTitle, string $id)
    {

        $widget = PostWidget::where('title', $widgetTitle)->first();

        if ($widget && $widget->is_active) 
        {

            $singlePost = $widget->getSinglePost($id);
            
            return $singlePost;

        }

    }

}
