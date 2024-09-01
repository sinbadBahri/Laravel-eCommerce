<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Product extends Model
{
        use HasFactory;
        
    
        /**
         * Returns the Brand of the Product
         * 
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function brand()
        {
        
            return $this->belongsTo
            (
                related: Brand::class,
                foreignKey: 'brand_id',
            );
            
        }
    
        /**
         * Returns the Tye of the Product.
         * This realation is useful because each type of product, has specific attributes.
         * 
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function productType()
        {
        
            return $this->belongsTo
            (
                related: Brand::class,
                foreignKey: 'product_type_id',
            );
            
        }
    
        /**
         * Returns All the categories anlong with their parents related to the product instance.
         * 
         * Note: Do not use $product->categories it will rais a Logic Error. 
         * use $product->categories() instead. 
         * 
         * @return \Illuminate\Database\Eloquent\Collection
         */
        public function categories()
        {
    
            # Get direct categories
            $categories = $this->belongsToMany
            (
                related: Category::class,
                table: 'category_product_relations'
            )
            ->get();
            
            # Load parent categories recursively
            $allCategories = $categories->flatMap(function ($category) {
    
                return $this->getCategoryWithAncestors($category);
            
            });
    
            # Remove duplicate categories and return
            return $allCategories->unique('id');
    
        }
    
        public function productLines()
        {
    
            return $this->hasMany 
            (
                related: ProductLine::class,
                foreignKey: 'product_id',
            );
            
        }
    
    
        private function getCategoryWithAncestors(Category $category): Collection
        {
    
            $ancestors = collect();
    
            // Recursively gather parent categories
            while ($category) {
                $ancestors->push($category);
                $category = $category->parent;
            }
    
            return $ancestors;
        
        }
    
    }