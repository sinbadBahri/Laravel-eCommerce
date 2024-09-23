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
        $newCategory = $this->makeOrUpdateCategory(request: $request);
        $this->attachImage(request: $request, category: $newCategory);

        return response()->json([
            'success' => true,
            'category' => $newCategory
        ]);
    }

    /**
     * An Edit Form of a specific Category.
     *
     * @param int $category_id The ID of the Category instance to be edited.
     * @return View The view for editing a Category instance.
     */
    public function edit(int $category_id): View
    {

        $category = Category::find($category_id);
        $allCategories = Category::all();

        return view(
            view: 'admin.forms.categoryEditForm',
            data: compact(['category', 'allCategories'])
        );

    }

    /**
     * Updates a Category regarding the provided request data and Category ID.
     *
     * @param Request $request The request containing the updated category data.
     * @param int $category_id The ID of the category to be updated.
     * @return RedirectResponse Redirects to the all categories list page with a success message.
     */
    public function update(Request $request, int $category_id): RedirectResponse
    {
        $category = $this->makeOrUpdateCategory(
            request: $request,
            category_id: $category_id,
        );

        $this->attachImage(
            request: $request,
            category: $category,
        );

        return redirect('/admin-panel/products/all-categories')
        ->with('success', 'Category Updated.');
    }

    /**
     * Validates the request data and creates or updates a Category instance.
     *
     * Note that this method could be called when either a Category instance is getting created or updated,
     * therefore when the $category_id is null probably the update method is calling this method.
     *
     * @param Request $request The request object containing the category data.
     * @param int|null $category_id The ID of the Category to update, or null if creating a new Category.
     * @return Category The updated or newly created Category instance.
     */
    private function makeOrUpdateCategory(Request $request, int $category_id = null): Category
    {
        # Validate the request data
        $request->validate([

            'name'  => ['required', 'string', 'max:255'],
            'slug'  => ['required', 'string', 'max:255'],

        ]);

        # Credentials to create or update a Category
        $credentials = [

            'name'        => $request->name,
            'slug'        => $request->slug,
            'parent_id'   => $request->parent,
            'status'      => $request->status      == "on" ? true : false,
            'is_feutured' => $request->is_feutured == "on" ? true : false,

        ];

        $category = Category::updateOrCreate(['id' => $category_id], $credentials);

        return $category;
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
                # Removes previous image (if there was)
                $this->imageUploadService->deleteCategoryImageBeforeUpload(
                    category: $category
                );

                # Upload the image
                $this->imageUploadService->uploadImageForCategory(
                    file: $imageFile,
                    category: $category,
                );
            }
        }
    }
}
