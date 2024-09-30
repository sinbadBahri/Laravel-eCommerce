<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;


    protected $fillable = ['title'];


    public function attributes()
    {

        return $this->belongsToMany
        (
            related: Attribute::class,
            table: 'product_type_attribute_relations',
        );

    }

    public function products()
    {

        return $this->hasMany
        (
            related: Product::class,
            foreignKey: 'product_type_id',
        );

    }

}
