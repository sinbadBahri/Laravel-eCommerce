<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Finance\Discount;
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
            'products'          => Product::all(),
            'productCollection' => ProductLine::all(),
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
        $productLine = $this->makeOrUpdateProductLine(request: $request);
        $this->attachImage(request: $request, productLine: $productLine);

        return response()->json([
            'success'      => true,
            'product_line' => $productLine
        ]);
    }

    /**
     * An Edit Form of a specific Product Line.
     *
     * @param int $product_line_id The ID of the ProductLine instance to be edited.
     * @return View The view for editing a ProductLine instance.
     */
    public function editProductLine(int $product_line_id): View
    {
        $content = [
            'discounts'   => Discount::all(),
            'products'    => Product::all(),
            'productLine' => ProductLine::find($product_line_id),
        ];

        return view(view: 'admin.forms.productLineEditForm', data: $content);

    }

    /**
     * Updates a ProductLine instance based on the provided request data and ProductLine ID.
     *
     * @param Request $request The request containing the updated product line data.
     * @param int $product_line_id The ID of the product line to be updated.
     * @return RedirectResponse Redirects to the product lines list page with a success message.
     */
    public function updateProductLine(Request $request, int $product_line_id): RedirectResponse
    {
        $productLine = $this->makeOrUpdateProductLine(
            request: $request,
            product_line_id: $product_line_id,
        );

        $this->updateDiscount(
            request: $request,
            productLine: $productLine,
        );

        $this->attachImage(
            request: $request,
            productLine: $productLine,
        );

        return redirect('/admin-panel/products')
        ->with('success', 'Product Line Updated.');
    }

    /**
     * Validates the request data for creating or updating a ProductLine instance.
     *
     * Note that this method could be called when either a ProductLine instance is getting created or updated,
     * therefore when the $product_line_id is null probably the updateProductLine method is calling this method.
     *
     * @param Request $request The request object containing the Product Line data.
     * @param int|null $product_line_id The ID of the ProductLine to update, or null if creating a new ProductLine.
     * @return ProductLine The updated or newly created ProductLine instance.
     */
    private function makeOrUpdateProductLine(Request $request,
    int $product_line_id = null): ProductLine
    {
        # Validate the request data
        $request->validate([

            'product'   => ['required'],
            'price'     => ['required', 'string'],
            'stock_qty' => ['required', 'string'],
            'sku'       => ['required', 'string', 'max:255', 'lowercase'],

        ]);

        $credentials = [

            'product_id'   => $request->product,
            'price'        => $request->price,
            'stock_qty'    => $request->stock_qty,
            'sku'          => $request->sku,
            'is_available' => $request->is_available == "on" ? true : false,

        ];

        $productLine = ProductLine::updateOrCreate(
            ['id' => $product_line_id], $credentials
        );

        return $productLine;
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
     * Updates the discount associated with the given ProductLine.
     *
     * This method retrieves the discount ID from the request and
     * delegates the task of updating the ProductLine's discount to
     * the setProductLineDiscount method.
     *
     * @param Request $request The incoming request containing the discount data.
     * @param ProductLine $productLine The ProductLine instance to be updated.
     * @return void
     */
    private function updateDiscount(Request $request, ProductLine $productLine): void
    {
        $discountId = $request->discount;

        $this->setProductLineDiscount($productLine, $discountId);
    }

    /**
     * Sets the discount for the provided ProductLine instance and persists it.
     *
     * This method assigns the provided discount ID (or null) to the ProductLine's
     * discount_id field and saves the change to the database.
     *
     * @param ProductLine $productLine The ProductLine instance to update.
     * @param int|null $discountId The discount ID to associate with the ProductLine, or null to remove the discount.
     * @return void
     */
    private function setProductLineDiscount(ProductLine $productLine, ?int $discountId): void
    {
        $productLine->discount_id = $discountId;
        $productLine->save();
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

        return response()->json([
            'success'     => true,
            'message'     => "New Product Type Added",
            'productType' => $productType,
        ]);
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

}
