<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog\Comment;
use App\Models\Blog\Genre;
use App\Models\Blog\Post;
use App\Models\Images\PostImage;
use App\Support\ImageUpload\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function postsList(): View
    {

        $blogPosts = Post::all();
        return view(view: 'admin.blog.postList', data: compact('blogPosts'));

    }

    /**
     * Deletes a Post based on the provided Post ID.
     *
     * @param Request $request The request containing the post ID to be deleted.
     * @return RedirectResponse A redirect response indicating the success message after deleting the post.
     */
    public function delete(Request $request): RedirectResponse
    {

        Post::find($request->post_id)->delete();
        return redirect()->back()->with('success','Post has been Deleted');

    }

    /**
     * Retrieves a Post Create Form.
     *
     * @return View The view for creating a new Post.
     */
    public function create(): View
    {

        $allGenres = Genre::all();
        return view(view: 'admin.forms.postCreateForm', data: compact('allGenres'));

    }

    /**
     * Store a new Post in the database.
     *
     * @param Request $request The HTTP request containing post data.
     * @return RedirectResponse A redirect response back with a success message.
     */
    public function store(Request $request): RedirectResponse
    {

        $newPost = $this->makeOrUpdatePost(request: $request);
        $this->addGenre(request: $request, post: $newPost);
        $this->attachImage(request: $request, post: $newPost);

        return redirect()->back()->with('success','Post Created');

    }

    /**
     * Create a new genre based on the provided request data.
     *
     * Validates the 'title' field from the request.
     * Creates a new genre with the validated title.
     *
     * @param Request $request The request containing the title of the new genre.
     * @return JsonResponse A JSON response indicating the success of the operation and the created category.
     */
    public function createNewGenre(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:100',
        ]);

        // Create the new category
        $category = Genre::create(['title' => $request->title]);

        // Return a JSON response
        return response()->json([
            'success' => true,
            'category' => $category
        ]);

    }

    /**
     * An Edit Form of a specific blog Post.
     *
     * @param Request $request The HTTP request containing the post ID.
     * @return View The view for editing a blog post.
     */
    public function edit(int $post_id): View
    {

        $post = Post::find($post_id);
        $allGenres = Genre::all();
        $comments = $post->comments;

        return view(
            view: 'admin.forms.postEditForm',
            data: compact(['post', 'allGenres', 'comments'])
        );

    }

    /**
     * Updates a Post regarding the provided request data and Post ID.
     *
     * @param Request $request The request containing the updated post data.
     * @param int $post_id The ID of the post to be updated.
     * @return RedirectResponse Redirects to the posts list page with a success message.
     */
    public function update(Request $request, int $post_id): RedirectResponse
    {

        $post = $this->makeOrUpdatePost(request: $request, post_id: $post_id);
        $this->addGenre(request: $request, post: $post);
        $this->attachImage(request: $request, post: $post);

        return redirect('/admin-panel/blog/posts-list')
        ->with('success','Post Updated');

    }

    /**
     * Validates the request data and creates or updates a Post instance.
     *
     * Note that this method could be called when either a Post is getting created or updated,
     * therefore when the $post_id is null probably the update method is calling this method.
     *
     * @param Request $request The request object containing the post data.
     * @param int|null $post_id The ID of the post to update, or null if creating a new post.
     * @return Post The updated or newly created post object.
     */
    private function makeOrUpdatePost(Request $request, int $post_id = null)
    {
        # Validate the request data
        $request->validate([

            'title'        => ['required', 'string', 'max:255'],
            'slug'         => ['required', 'string', 'max:255', 'lowercase'],
            'description'  => ['required', 'string', 'max:3000'],

        ]);

        # Credentials to create or update a Post
        $credentials = [

            'title'        => $request->title,
            'slug'         => $request->slug,
            'description'  => $request->description,
            'status'       => $request->publish == "on" ? true : false,

        ];

        $post = Post::updateOrCreate(['id' => $post_id], $credentials);

        return $post;

    }

    /**
     * Syncs Genres to a Post if Genres are provided in the request.
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

                $post->genres()->sync($genre_id);

            }

            $post->save();
        }
    }

    /**
     * Attaches an image to a post if a file is present in the request.
     *
     * If the request contains an image file, the function validates the image, converts it to binary,
     * retrieves the MIME type, and creates a new PostImage entry with the image details linked to the post.
     *
     * @param Request $request The HTTP request containing the image file.
     * @param Post $post The post to which the image will be attached.
     * @return void
     */
    private function attachImage(Request $request, Post $post): void
    {
        if ($request->hasFile('image'))
        {
            $imageFile = $request->file('image');

            # Validate the image using the ImageUploadService
            if ($this->imageUploadService->isValid($imageFile))
            {
                # Upload the image
                $this->imageUploadService->uploadImageForPost(
                    file: $imageFile,
                    post: $post,
                );
            }
        }
    }

    /**
     * Bulk delete comments for a specific post.
     *
     * This method deletes multiple comments associated with a post based on the
     * selected comment IDs provided in the request.
     *
     * @param Request $request The request object containing the selected comment IDs.
     * @param int $post_id The ID of the post for which comments are being deleted.
     * @return RedirectResponse A redirect response to the post edit page with a success
     * message if comments are deleted successfully, or with an error message if no comments are selected.
     */
    public function bulkDeleteComments(Request $request, int $post_id): RedirectResponse
    {

        if ($commentIds = $request->selected_comments)
        {

            Comment::whereIn('id', $commentIds)->delete();
            return redirect()->route('post.edit', $post_id)
            ->with('success', count($commentIds)." comments deleted successfully.");

        }

        return redirect()->route('post.edit', $post_id)
        ->with('error', 'No comments selected.');

    }
}
