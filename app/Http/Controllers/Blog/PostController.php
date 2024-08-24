<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\Comment;
use App\Models\Blog\Genre;
use App\Models\Widgets\CommentWidget;
use App\Models\Widgets\PostWidget;
use App\Support\Master\Master;
use Illuminate\Http\Request;

class PostController extends Controller
{

    protected $master;


    public function __construct(Master $master)
    {
    
        $this->master = $master;
    
    }

    public function index(string $slug)
    {
        
        $navbar_footer_content = $this->master->setNavbarAndFooter();
        
        $posts = $this->showPostsFromWidget(slug: $slug);

        $content = array_merge(

            # Navbar & Footer
            $navbar_footer_content,

            # Body Widgets
            ['posts' => $posts],

        );
        

        return view('post.all', $content);
        
    }

    public function show(string $id)
    {
        # Navbar & Footer
        $navbar_footer_content = $this->master->setNavbarAndFooter();

        # Body Widgets & Necessary Data
        $widget_content = $this->getBodyWidgets($id);

        $content = array_merge(

            # Navbar & Footer
            $navbar_footer_content,

            # Body Widgets & Necessary Data
            $widget_content

        );
        

        return view('post.single', $content);
        
    }

    /**
     * Retrieves the necessary body widgets for a given post ID.
     * 
     * The returned array can be pushed to a blade view.
     *
     * @param string $id The ID of the post to retrieve widgets for.
     * @return array An array containing a single post widget, widget of the post's comments, and total comment quantity.
     */
    private function getBodyWidgets(string $id)
    {

        # Body Widgets
        $singlePost = $this->getPostWidget($id);
        $postComments = $this->getPostComments($id);

        # Necessary Data
        $commentQuantity = $this->countTotalComments($id);

        $widget_content = [

            # Body Widgets
            'singlePost' => $singlePost,
            'postComments'=> $postComments,

            # Necessary Data
            'commentQuantity'=> $commentQuantity,
        ];

        return $widget_content;
        
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
