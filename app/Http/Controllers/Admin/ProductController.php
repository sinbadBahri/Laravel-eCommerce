<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductLine;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function index()
    {
        $content = ['productCollection' => ProductLine::all()];
        return view(view: "admin.product.productList", data: $content);
    }

    public function addProduct()
    {

        return view(view: 'admin.forms.addProduct');
        
    }

    public function categoriesView()
    {
        return view(view: 'admin.product.allCategories');
    }

    public function attributesView()
    {
        return view(view: 'admin.product.attributes');
    }
}
