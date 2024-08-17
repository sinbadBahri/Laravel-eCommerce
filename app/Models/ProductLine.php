<?php

namespace App\Models;

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

}