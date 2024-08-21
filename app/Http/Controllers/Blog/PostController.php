<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\Comment;
use App\Models\Blog\Genre;
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

    public function index(string $slug)
    {

        # Navbar
        $cartItems = $this->navbar->cartItems;
        $genres = $this->navbar->genres;

        # Body Widgets
        $posts = $this->showPostsFromWidget(slug: $slug);

        # Footer
        $footerCollection = $this->footer->getAllFooterItems();

        $content = [
            # Navbar
            'cartItems',
            'genres',

            # Body Widgets
            'posts',

            # Footer
            'footerCollection',
        ];

        return view("post.all", compact($content));
        
        
    }

    public function show(string $id)
    {

        # Navbar
        $cartItems = $this->navbar->cartItems;
        $genres = $this->navbar->genres;

        # Body Widgets
        $singlePost = $this->getPostWidget($id);
        $postComments = $this->getPostComments($id);

        # Necessary Data
        $commentQuantity = $this->countTotalComments($id);

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

    /**
     * Retrieves a single post from a specific widget.
     * 
     * By default the name of widget defined as "single".
     * Do not change the default value if it's not necessary.
     *
     * @param string $id The ID of the post to fetch from the widget.
     * @param string $widgetTitle The title of the widget to retrieve. Default is "single".
     * @return mixed The single post if found and active in the widget; otherwise, null.
     */
    private function getPostWidget(string $id, string $widgetTitle = "single")
    {

        $widget = PostWidget::where('title', $widgetTitle)->first();

        if ($widget && $widget->is_active) 
        {

            $singlePost = $widget->getSinglePost($id);
            
            return $singlePost;

        }

    }

    /**
     * Retrieves comments for a specific post based on the title and ID.
     *
     * By default the name of widget defined as "main".
     * Do not change the default value if it's not necessary.
     * 
     * @param string $id The ID of the post.
     * @param string $title The title of the comment widget. Default is "main".
     * @return mixed The comments for the post if the widget is active, null otherwise.
     */
    private function getPostComments(string $id, string $title = "main")
    {

        $widget = CommentWidget::where('title', $title)->first();
        
        if ($widget && $widget->is_active)
        {

            $postComments = $widget->getOrphanComments($id);

            return $postComments;

        }
    }

    /**
     * Count the total number of comments for a specific post.
     *
     * By default the name of related widget defined as "main".
     * Do not change the default value if it's not necessary.
     * 
     * @param string $id The ID of the post to count comments for.
     * @param string $title The title of the comment widget. Default is "main".
     * @return int|null The total number of comments for the post, or null if no comments found.
     */
    private function countTotalComments(string $id, string $title = "main")
    {

        $widget = CommentWidget::where('title', $title)->first();
        
        if ($widget && $widget->is_active)
        {

            $commentQuantity = $widget->getCommentsQuantity($id);

            return $commentQuantity;

        }
    }

    /**
     * Retrieves posts from a widget based on the provided slug and widget title.
     * 
     * By default the name of widget defined as "posts_page".
     * Do not change the default value if it's not necessary.
     *
     * @param string
     * @param string 
     * @return array|null The array of posts retrieved from the widget, or null if no active widget found.
     */
    private function showPostsFromWidget(string $slug, string $widgetTitle = "posts_page")
    {

        $widget = PostWidget::where('title', $widgetTitle)->first();

        if ($widget && $widget->is_active)
        {

            $posts = $widget->getPostsWithGenre(
                $this->getGenreIdFromSlug($slug)
            );

            return $posts;

        }
    }

    /**
     * Get the genre ID based on the given genre title.
     *
     * If the genre title is "allgenres", returns null.
     * Otherwise, retrieves the genre ID from the database based on the title.
     *
     * @param string $genre_title The title of the genre.
     * @return int|null The ID of the genre if found, otherwise null.
     */
    private function getGenreIdFromSlug(string $genre_title)
    {

        if ($genre_title == "allgenres")
        {
            return null;
        }
        else
        {

            $genre = Genre::where("title", $genre_title)->first();
            return $genre->id;

        }
        
    }

}
