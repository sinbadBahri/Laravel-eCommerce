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
        return view(view: "admin.productList", data: $content);
    }
}
