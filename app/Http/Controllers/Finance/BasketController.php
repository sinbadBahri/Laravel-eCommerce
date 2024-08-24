<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\ProductLine;
use App\Support\Basket\Basket;
use Illuminate\Http\Request;

class BasketController extends Controller
{

    private $basket;

    public function __construct(Basket $basket)
    {

        $this->basket = $basket;
    
    }

    public function add(ProductLine $productLine, int $quantity = 1)
    {

        $this->basket->add($productLine, $quantity);
        
    }
}
