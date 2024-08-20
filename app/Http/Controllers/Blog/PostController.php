<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\Comment;
use App\Models\Widgets\CommentWidget;
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
        $postComments = $this->getPostComments("main", $id);

        # Necessary Data
        $commentQuantity = $this->countTotalComments("main", $id);

        # Footer
        $footerCollection = $this->footer->getAllFooterItems();

        $content = [
            # Navbar
            'cartItems',
            'genres',

            # Body Widgets
            'singlePost',
            'postComments',

            # Necessary Data
            'commentQuantity',

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

    private function getPostComments(string $title, string $id)
    {

        $widget = CommentWidget::where('title', $title)->first();
        
        if ($widget && $widget->is_active)
        {

            $postComments = $widget->getOrphanComments($id);

            return $postComments;

        }
    }

    private function countTotalComments(string $title, string $id)
    {

        $widget = CommentWidget::where('title', $title)->first();
        
        if ($widget && $widget->is_active)
        {

            $commentQuantity = $widget->getCommentsQuantity($id);

            return $commentQuantity;

        }
    }

}
