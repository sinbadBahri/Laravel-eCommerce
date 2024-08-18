<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    
    public function products()
    {

        return $this->belongsToMany(
            related:ProductLine::class,
            table:'cart_product_relations',
        )
        ->withPivot('quantity')
        ->withTimestamps();

    }
    
    public static function getTotalQuantity($cart_id)
    {

        $cart = self::findOrFail($cart_id);       

        $totalQuantity = $cart->products()->sum('cart_product_relations.quantity');

        return $totalQuantity;
    }

    public static function totalPrice($cart_id)
    {

        $cart = self::findOrFail($cart_id);

        $totalPrice = $cart->products()->get()->sum(function ($product) {
            return $product->price * $product->pivot->quantity;
        });

        return $totalPrice;
    }

}