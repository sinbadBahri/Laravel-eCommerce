<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\ProductLine;
use App\Models\Widgets\CategoryWidget;
use App\Models\Widgets\ProductWidget;
use App\Support\Footer;
use Illuminate\Http\Request;

class MainController extends Controller
{

    protected $footer;


    public function __construct(Footer $footer) {
        
        $this->footer = $footer;

    }

    public function index()
    {

        $footerCollection = $this->footer->getAllFooterItems();
        $product_widget_slider = ProductWidget::with('products.images')->where('is_active', true)
        ->where('title', 'slider')->first();
        $best_seller_widget = ProductWidget::with('products.images')->where('is_active', true)
        ->where('title', 'bestSeller')->first();
        $special_offer_widget = ProductWidget::with('products.images')->where('is_active', true)
        ->where('title', 'special-offer')->first();
        $laptop_widget = ProductWidget::with('products.images')->where('is_active', true)
        ->where('title', 'لپ تاپ ها')->first();
        $mobile_widget = ProductWidget::with('products.images')->where('is_active', true)
        ->where('title', 'موبایل ها')->first();
        $category_widget = CategoryWidget::with('categories.image')->where('is_active', true)->first();

        $cartItems = $this->getCartTotal();
        
        $content = [
            'product_widget_slider',
            'footerCollection',
            'category_widget',
            'best_seller_widget',
            'cartItems',
            'special_offer_widget',
            'laptop_widget',
            'mobile_widget',
        ];

        return view('index', compact($content));
        
    }

    public function updateItem(Request $request)
    {

        $this->createOrUpdateCart($request);

        return redirect()->back();

    }

    private function getCartTotal()
    {

        $cartItems = 0;

        if (Cart::exists())
        {

            // $cart_id = TmpCart::where('user_id', auth()->id())->id;  # If we have already defined the authentication system.
            $cart_id = Cart::first()->id;
            $cartItems = Cart::getTotalQuantity(cart_id:$cart_id);

        }

        return $cartItems;

    }

    private function getTotalPrice()
    {

        $totalPrice = 0;

        if (Cart::exists())
        {

            // $cart_id = TmpCart::where('user_id', auth()->id())->id;  # If we have already defined the authentication system.
            $cart_id = Cart::first()->id;
            $totalPrice = Cart::totalPrice(cart_id:$cart_id);

        }

        return $totalPrice;

    }

    private function createOrUpdateCart(Request $request): Cart
    {

        $product = ProductLine::findOrFail($request->product_id);

        if (! $quantity = $request->quantity)
        {

            $quantity = 1;

        }

        $cart = Cart::firstOrCreate(
            // [
            //     'user_id' => auth()->id(),
            // ]
        );

        $cartProduct = $cart->products()->where('product_line_id', $request->product_id)->first();

        if ($cartProduct)
        {

            # If the product is already in the cart, increment the quantity
            $cartProduct->pivot->quantity += $quantity;
            $cartProduct->pivot->save();
        
        }
        else
        {
            
            # If the product is not in the cart, add it with a quantity of 1
            $cart->products()->attach($request->product_id, ['quantity' => $quantity]);
        
        }

        return $cart;

    }

}
