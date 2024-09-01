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

    /**
     * Retrieves various widgets including product sliders, best sellers, special offers, laptops, mobiles, categories, and posts.
     * 
     * These widgets return as a key-value array, so that can be pushed as a content data to
     * the Blade files.
     *
     * @return array Contains the retrieved widgets for display on the main page.
     */
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
        $posts = $this->showPostsFromWidget(3);
        
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

    /**
     * Retrieves posts from a specific widget based on the widget title and the number of posts to fetch.
     * 
     * By default the name of widget defined as "main-page".
     * Do not change the default value if it's not necessary.
     * 
     * @param int $number The number of posts to fetch.
     * @param string $widgetTitle The title of the widget to retrieve posts from. Default is 'main-page'.
     * @return array|null The array of posts if the widget is active and posts are retrieved, otherwise null.
     */
    private function showPostsFromWidget(int $number, string $widgetTitle = 'main-page')
    {

        $widget = PostWidget::where('title', $widgetTitle)->first();

        if ($widget && $widget->is_active)
        {

            $posts = $widget->getSomePosts($number);

            return $posts;

        }
    }

    public function reloadCartItems()
    {
        $masterContent = $this->master->setNavbarAndFooter();
        $cartItems = $masterContent['cartItems'];
        return response()->json(['cartItems' => $cartItems]);
        
    }
    
}
