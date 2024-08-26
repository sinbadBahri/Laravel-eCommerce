<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
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
        $totalPrice = $this->basket->subTotal();

        $content = array_merge(
            # Navbar & Footer
            $navbar_footer_content,
            
            # Body Widgets
            [
                'totalPrice'=> $totalPrice,
            ],
        );
        
        return view("finance.checkout", $content);
        
    }
}
