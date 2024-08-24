<?php

namespace App\Models;

use App\Models\Images\ProductImage;
use App\Models\Widgets\ProductWidget;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLine extends Model
{
    use HasFactory;


    public function product()
    {

        return $this->belongsTo
        (
            related: Product::class,
            foreignKey: 'product_id',
        );
    
    }
        
    public function attributeValues()
    {

        return $this->belongsToMany
        (

            related: AttributeValue::class,
            table: 'product_line_attr_values',

        );
        
    }


    public function images()
    {

        return $this->hasMany(related:ProductImage::class);
        
    }


    public function widgets()
    {

        return $this->belongsToMany
        (
            related: ProductWidget::class,
            table: 'product_widget_product_line',
        );
        
    }

    public function hasStock(int $quantity)
    {

        return $this->stock_qty >= $quantity;
        
    }

}