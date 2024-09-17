<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductLine;
use App\Models\ProductType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function index(): View
    {
        $content = ['productCollection' => ProductLine::all()];
        return view(view: "admin.product.productList", data: $content);
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

        return redirect()->back()->with('success','New Base Product Created');
        
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

        if ($request->categories !== null)
        {
            foreach ($request->categories as $category_id)
            {
    
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
