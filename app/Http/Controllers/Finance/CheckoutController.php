<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Tax;
use App\Support\Basket\Basket;
use App\Support\Master\Master;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class CheckoutController extends Controller
{

    private $basket;
    private $master;


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
        $totalPrice = $this->basket->getTaxFreeTotal();
        $finalPriceWithDiscount = $this->basket->getTotalWithDiscount();
        $taxPercentage = Tax::first()->percentage;
        $totalWithTax = $this->basket->getTotalWithTax();

        $content = array_merge(
            # Navbar & Footer
            $navbar_footer_content,
            
            # Body Widgets
            [
                'totalPrice'=> $totalPrice,
                'finalPriceWithDiscount'=> $finalPriceWithDiscount,
                'taxPercentage'=> $taxPercentage,
                'totalWithTax'=> $totalWithTax,

            ],
        );
        
        return view("finance.checkout", $content);
        
    }
}
