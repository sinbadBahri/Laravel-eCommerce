<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Tax;
use App\Support\Basket\Basket;
use App\Support\Master\Master;
use App\Support\Transaction\Transaction;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    private $basket;
    private $master;
    protected $transaction;


    public function __construct(Basket $basket, Master $master, Transaction $transaction)
    {
        $this->basket = $basket;
        $this->master = $master;
        $this->transaction = $transaction;
    }

    public function index()
    {
        # Navbar & Footer
        $navbar_footer_content = $this->master->setNavbarAndFooter();

        # Body Informations
        $body_content = $this->getBodyContent();

        $content = array_merge(
            # Navbar & Footer
            $navbar_footer_content,

            # Body Informations
            $body_content,
        );
        
        return view("finance.checkout", $content);
        
    }

    public function checkout(Request $request)
    {
        return $this->transaction->checkout();
    }

    private function getBodyContent()
    {

        # Body Informations
        $totalPrice = $this->basket->getTaxFreeTotal();
        $finalPriceWithDiscount = $this->basket->getTotalWithDiscount();
        $taxPercentage = Tax::first()->percentage;
        $totalWithTax = $this->basket->getTotalWithTax();
        
        $content = [

            # Body Informations
            'totalPrice'=> $totalPrice,
            'finalPriceWithDiscount'=> $finalPriceWithDiscount,
            'taxPercentage'=> $taxPercentage,
            'totalWithTax'=> $totalWithTax,

        ];

        return $content;

    }
}
