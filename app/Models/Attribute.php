<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];
    

    public function product_types()
    {

        return $this->belongsToMany
        (
            related: ProductType::class,
            table: 'product_type_attribute_relations',
        );

    }

    public function attribute_values()
    {

        return $this->hasMany
        (
            related: AttributeValue::class,
            foreignKey: 'attribute_id'
        );

    }

}
