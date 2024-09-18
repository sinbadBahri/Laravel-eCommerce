<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Images\ProductImage;
use App\Models\Product;
use App\Models\ProductLine;
use App\Models\ProductType;
use App\Support\ImageUpload\ImageUploadService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function index(): View
    {
        $content = [
            'productCollection' => ProductLine::all(),
            'products' => Product::all(),
        ];

        return view(view: "admin.product.productList", data: $content);
    }

    /**
     * Removes a product line based on the provided request.
     *
     * @param Request $request The request containing the product line ID to be removed.
     * @return RedirectResponse A redirect response indicating the success message after deleting the product line.
     */
    public function removeProductLine(Request $request): RedirectResponse
    {
        ProductLine::find($request->product_line_id)->delete();

        return redirect()->back()->with('success', 'Product Line has been Deleted');
    }

    /**
     * Stores a new ProductLine instance with the provided request data.
     *
     * @param Request $request The request containing the product line data and image.
     * @return JsonResponse JSON response indicating the success status and the created product line.
     */
    public function storeProductLine(Request $request): JsonResponse
    {
        $productLine = $this->makeProductLine($request);
        $this->attachImage($request, $productLine);

        return response()->json([
            'success' => true,
            'product_line' => $productLine
        ]);
    }

    /**
     * Validates the request data for creating a new product line.
     *
     * @param Request $request The request object containing the product line data.
     * @return ProductLine The newly created product line.
     */
    private function makeProductLine(Request $request): ProductLine
    {
        # Validate the request data
        $request->validate([

            'product'   => ['required'],
            'price'     => ['required', 'string'],
            'stock_qty' => ['required', 'string'],
            'sku'       => ['required', 'string', 'max:255', 'lowercase', 'unique:product_lines'],

        ]);

        return ProductLine::create([

            'product_id'   => $request->product,
            'price'        => $request->price,
            'stock_qty'    => $request->stock_qty,
            'sku'          => $request->sku,
            'is_available' => $request->is_available == "on" ? true : false,

        ]);
    }

    /**
     * Attaches an image to a Product Line if a file is present in the request.
     * 
     * If the request contains an image file, the function validates the image,
     * converts it to binary, retrieves the MIME type, and creates a new ProductImage
     * entry with the image details linked to the Product Line.
     * 
     * @param Request $request The HTTP request containing the image file.
     * @param ProductLine $productLine The ProductLine instance to which the image will be attached.
     * @return void
     */
    private function attachImage(Request $request, ProductLine $productLine): void
    {
        if ($request->hasFile('image'))
        {
            $imageFile = $request->file('image');

            # Validate the image using the ImageUploadService
            if ($this->imageUploadService->isValid($imageFile))
            {
                # Upload the image
                $this->imageUploadService->uploadImageForProduct(
                    file: $imageFile,
                    productLine: $productLine,
                );
            }
        }
    }

    /**
     * Retrieves a Product create Form.
     * 
     * @return View The view for creating a new Product.
     */
    public function addProductForm(): View
    {

        $brands = Brand::all();
        $product_types = ProductType::all();
        $categories = Category::all();

        $data = [
            'brands',
            'product_types',
            'categories',
        ];

        return view(view: 'admin.forms.addProductForm', data: compact($data));
    }

    /**
     * Creates a new Brand instance based on the provided request data.
     *
     * @param Request $request The request containing the title of the Brand.
     * @return JsonResponse JSON response with the newly created Brand.
     */
    public function createNewBrand(Request $request): JsonResponse
    {

        $request->validate(['title' => ['required', 'string', 'max:100']]);
        $brand = Brand::create(['title' => $request->title]);

        return response()->json(['brand' => $brand]);
    }

    /**
     * Creates a new ProductType instance based on the provided request data.
     *
     * @param Request $request The request containing the title of the new ProductType.
     * @return JsonResponse JSON response with the newly created ProductType.
     */
    public function createNewProductType(Request $request): JsonResponse
    {

        $request->validate(['title' => ['required', 'string', 'max:100']]);
        $productType = ProductType::create(['title' => $request->title]);

        return response()->json(['product_type' => $productType]);
    }

    /**
     * Stores a new Product based on the provided request data.
     * 
     * After validating the request data, creates a new instance of Product Class.
     * Then if the request included Categories, attaches them to the new Product. 
     *
     * @param Request $request The request containing the product data.
     * @return RedirectResponse A redirect response indicating the success of creating a new base product.
     */
    public function storeProduct(Request $request): RedirectResponse
    {

        $newProduct = $this->makeProduct(request: $request);
        $this->addCategory(request: $request, product: $newProduct);

        return redirect()->back()->with('success', 'New Base Product Created');
    }

    /**
     * Validates the request data and returns a new Product.
     *
     * @param Request $request The HTTP request containing the product data.
     * @return Product The newly created Product object.
     */
    private function makeProduct(Request $request): Product
    {
        # Validate the request data
        $request->validate([

            'name'         => ['required', 'string', 'max:255', 'unique:products'],
            'slug'         => ['required', 'string', 'max:255', 'lowercase'],
            'description'  => ['required', 'string', 'max:3000'],
            'brand'        => ['required'],
            'product_type' => ['required'],

        ]);

        return Product::create([

            'name'            => $request->name,
            'slug'            => $request->slug,
            'description'     => $request->description,
            'brand_id'        => $request->brand,
            'product_type_id' => $request->product_type,

        ]);
    }

    /**
     * Attaches Categories to a Product.
     *
     * @param Request $request The HTTP request containing the categories to add.
     * @param Product $product The product to add categories to.
     * @return void
     */
    private function addCategory(Request $request, Product $product): Void
    {

        if ($request->categories !== null) {
            foreach ($request->categories as $category_id) {

                $product->categories()->attach($category_id);
            }

            $product->save();
        }
    }

    public function categoriesView()
    {
        return view(view: 'admin.product.allCategories');
    }

    public function attributesView()
    {
        return view(view: 'admin.product.attributes');
    }
}
