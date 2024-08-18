<?php

namespace App\Http\Controllers;

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
        $product_widget = ProductWidget::with('products.images')->where('is_active', true)->first();
        
        $content = ['product_widget', 'footerCollection'];

        return view('welcome', compact($content));
        
    }

}
