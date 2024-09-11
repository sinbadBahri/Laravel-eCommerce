<?php

namespace App\Http\Controllers\Finance;

use App\Exceptions\QuantityExceededException;
use App\Http\Controllers\Controller;
use App\Models\ProductLine;
use App\Support\Basket\Basket;
use App\Support\Master\Master;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BasketController extends Controller implements HasMiddleware
{
    
    private $basket;
    private $master;
    

    public static function middleware()
    {

        return [
            new Middleware(middleware: 'auth', only: ['index']),
        ];
        
    }
    
    public function __construct(Basket $basket, Master $master)
    {
        
        $this->basket = $basket;
        $this->master = $master;
        
    }

    public function index()
    {
        # Navbar & Footer
        $navbar_footer_content = $this->master->setNavbarAndFooter();

        # Body Widgets
        $productCollection = $this->basket->allProducts();
        $totalPrice = $this->basket->getTaxFreeTotal();
        $finalPriceWithDiscount = $this->basket->getTotalWithDiscount();
        
        
        $content = array_merge(
            # Navbar & Footer
            $navbar_footer_content,
            
            # Body Widgets
            [
                'productCollection' => $productCollection,
                'totalPrice' => $totalPrice,
                'finalPriceWithDiscount' => $finalPriceWithDiscount,
            ],
        );
        
        return view("finance.basket", $content);
        
    }

    public function add(Request $request)
    {

        try
        {
        
            $this->updateBasket($request);
    
            return redirect()->back()->with('success', __("Product Added"));
        
        }
        catch (QuantityExceededException $exception)
        {

            return redirect()->back()->with('success', __("No More Product Left"));
        
        }
        
    }

    public function clearAll(): RedirectResponse
    {

        $this->basket->clear();

        return redirect()->back()->with("success", __("Basket Cleared"));
        
    }

    public function remove(Request $request): RedirectResponse
    {

        $this->basket->remove($request->productLineId);

        return redirect()->back()->with("success", __("Item Removed Successfully"));
    
    }

    /**
     * Updates the basket with the specified product line and quantity.
     *
     * If the quantity is not provided in the request, it defaults to 1.
     *
     * @param Request $request
     * @return void
     */
    private function updateBasket(Request $request): void
    {

        if (! $quantity = $request->quantity)
        {

            $quantity = 1;

        }

        $productLine = ProductLine::findOrFail($request->productLine);

        $this->basket->add($productLine, $quantity);
        
    }
}
