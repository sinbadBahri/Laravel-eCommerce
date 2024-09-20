<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Support\ImageUpload\ImageUploadService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function index(): View
    {
        $categories = Category::all();

        return view(view: 'admin.product.allCategories', data: compact(['categories']));
    }

    /**
     * Removes a Category instance based on the provided request.
     *
     * @param Request $request The request containing the Category ID to be removed.
     * @return RedirectResponse A redirect response indicating the success message after deleting the Category.
     */
    public function delete(Request $request): RedirectResponse
    {
        Category::find($request->category_id)->delete();

        return redirect()->back()->with('success', 'Category has been Deleted');
    }

    /**
     * Stores a new Category instance with the provided request data.
     *
     * @param Request $request The request containing the category data and image.
     * @return JsonResponse JSON response indicating the success status and the created Category.
     */
    public function store(Request $request): JsonResponse
    {
        $newCategory = $this->makeCategory(request: $request);
        $this->attachImage(request: $request, category: $newCategory);

        return response()->json([
            'success' => true,
            'category' => $newCategory
        ]);
    }

    /**
     * Validates the request data for creating a new Category instance.
     *
     * @param Request $request The request object containing the category data.
     * @return Category The newly created Category instance.
     */
    private function makeCategory(Request $request): Category
    {
        # Validate the request data
        $request->validate([

            'name'  => ['required', 'string', 'max:255', 'unique:categories'],
            'slug'  => ['required', 'string', 'max:255', 'lowercase'],

        ]);

        return Category::create([

            'name'        => $request->name,
            'slug'        => $request->slug,
            'parent_id'   => $request->parent,
            'status'      => $request->status      == "on" ? true : false,
            'is_feutured' => $request->is_feutured == "on" ? true : false,

        ]);
    }

    /**
     * Attaches an image to a Category if a file is present in the request.
     *
     * If the request contains an image file, the function validates the image,
     * converts it to binary, retrieves the MIME type, and creates a new CategoryImage
     * entry with the image details linked to the Category.
     *
     * @param Request $request The HTTP request containing the image file.
     * @param Category $category The Category instance to which the image will be attached.
     * @return void
     */
    private function attachImage(Request $request, Category $category): void
    {
        if ($request->hasFile('image'))
        {
            $imageFile = $request->file('image');

            # Validate the image using the ImageUploadService
            if ($this->imageUploadService->isValid($imageFile))
            {
                # Upload the image
                $this->imageUploadService->uploadImageForCategory(
                    file: $imageFile,
                    category: $category,
                );
            }
        }
    }
}
