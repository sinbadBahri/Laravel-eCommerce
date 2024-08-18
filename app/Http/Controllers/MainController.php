<?php

namespace App\Http\Controllers;

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
        $category_widget = CategoryWidget::with('categories.image')->where('is_active', true)->first();
        
        $content = [
            'product_widget_slider',
            'footerCollection',
            'category_widget',
            'best_seller_widget',
        ];

        return view('welcome', compact($content));
        
    }

}
