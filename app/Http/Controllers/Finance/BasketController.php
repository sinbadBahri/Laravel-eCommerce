<?php

namespace App\Http\Controllers\Finance;

use App\Exceptions\QuantityExceededException;
use App\Http\Controllers\Controller;
use App\Models\ProductLine;
use App\Support\Basket\Basket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BasketController extends Controller
{

    private $basket;

    public function __construct(Basket $basket)
    {

        $this->basket = $basket;
    
    }

    public function add(Request $request): RedirectResponse
    {

        try
        {
        
            $this->updateBasket($request);
    
            return redirect()->back()->with("success", __("Product Added"));
        
        }
        catch (QuantityExceededException $exception)
        {

            return redirect()->back()->with("error", __("No More Product Left"));
        
        }
        
    }

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
