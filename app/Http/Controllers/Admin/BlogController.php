<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog\Genre;
use App\Models\Blog\Post;
use App\Models\Images\PostImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    
    public function postsList()
    {

        $blogPosts = Post::all();
        return view(view: 'admin.blog.postList', data: compact('blogPosts'));
        
    }

    public function delete(Request $request): RedirectResponse
    {

        Post::find($request->trash_post_id)->delete();
        return redirect()->back()->with('success','Post has been Deleted');
        
    }

    public function create()
    {

        $allGenres = Genre::all();
        return view(view: 'admin.forms.postForm', data: compact('allGenres'));

    }

    /**
     * Store a new Post in the database.
     *
     * @param Request $request The HTTP request containing post data.
     * @return RedirectResponse A redirect response back with a success message.
     */
    public function store(Request $request): RedirectResponse
    {

        $newPost = $this->makePost(request: $request);
        $this->addGenre(request: $request, post: $newPost);
        $this->attachImage(request: $request, post: $newPost);

        return redirect()->back()->with('success','Post Created');
        
    }

    /**
     * Validates the request data and creates a new Post.
     *
     * @param Request $request The request object containing the post data.
     * @return Post The newly created post object.
     */  
    private function makePost(Request $request)
    {
        # Validate the request data
        $request->validate([
            
            'title'        => ['required', 'string', 'max:255'],
            'slug'         => ['required', 'string', 'max:255', 'lowercase'],
            'description'  => ['required', 'string', 'max:3000'],
        
        ]);

        $newPost = Post::create([

            'title'        => $request->title,
            'slug'         => $request->slug,
            'description'  => $request->description,
            'status'       => $request->publish == "on" ? true : false,
        
        ]);

        return $newPost;
        
    }

    /**
     * Attach Genres to a Post if Genres are provided in the request.
     *
     * @param Request $request The HTTP request containing genres data.
     * @param Post $post The post to attach genres to.
     * @return void
     */
    private function addGenre(Request $request, Post $post): void
    {

        if ($request->genres !== null)
        {
            foreach ($request->genres as $genre_id)
            {
    
                $post->genres()->attach($genre_id);
    
            }
            
            $post->save();
        }
    }

    /**
     * Attach an image to a post if a file is present in the request.
     * 
     * If the request contains an image file, the function validates the image, converts it to binary, 
     * retrieves the MIME type, and creates a new PostImage entry with the image details linked to the post.
     * 
     * @param Request $request The HTTP request containing the image file.
     * @param Post $post The post to which the image will be attached.
     * @return void
     */
    private function attachImage(Request $request, Post $post)
    {
        
        if ($request->hasFile('image'))
        {

            $imageFile = $request->file('image');

            if (PostImage::validateImage($imageFile) == true)
            {
                # Convert the Image to binary
                $imageBlob = file_get_contents($imageFile);
    
                # Get MIME type
                $imageType = $imageFile->getMimeType();
    
                PostImage::create([
    
                    'alternative_text' => "Image of {$request->title}",
                    'mime_type'        => $imageType,
                    'image'            => $imageBlob,
                    'post_id'          => $post->id,
                
                ]);
    
                $post->save();

            };            
        }
    }
}
