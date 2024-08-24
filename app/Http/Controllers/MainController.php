<?php

namespace App\Http\Controllers;


use App\Models\Widgets\CategoryWidget;
use App\Models\Widgets\PostWidget;
use App\Models\Widgets\ProductWidget;
use App\Support\Master\Master;

class MainController extends Controller
{

    private $master;



    public function __construct(Master $master)
    {
        
        $this->master = $master;

    }

    public function index()
    {

        $navbar_footer_content = $this->master->setNavbarAndFooter();

        $widget_content = $this->getBodyWidgets();

        $content = array_merge(

            # Navbar & Footer
            $navbar_footer_content,

            # Body Widgets
            $widget_content,

        );
        

        return view('index', $content);
        
    }

    private function getBodyWidgets()
    {
        
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
        $posts = $this->showPostsFromWidget('main-page', 3);
        
        $widget_content = [

            # Body Widgets
            'product_widget_slider' => $product_widget_slider,
            'category_widget'       => $category_widget,
            'best_seller_widget'    => $best_seller_widget,
            'special_offer_widget'  => $special_offer_widget,
            'laptop_widget'         => $laptop_widget,
            'mobile_widget'         => $mobile_widget,
            'posts'                 => $posts,
        ];
        
        return $widget_content;

    }

    private function showPostsFromWidget(string $widgetTitle, int $number)
    {

        $widget = PostWidget::where('title', $widgetTitle)->first();

        if ($widget && $widget->is_active)
        {

            $posts = $widget->getSomePosts($number);

            return $posts;

        }
    }

}
