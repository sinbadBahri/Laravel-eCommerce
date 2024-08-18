<?php

namespace App\Models;

use App\Models\Images\CategoryImage;
use App\Models\Widgets\CategoryWidget;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    // public function __construct(string $name)
    // {

    //     $this->name = $name;
    //     $this->generateSlug(); 
    
    // }

    public function children()
    {
    
        return $this->hasMany(Category::class, 'parent_id');
    
    }

    public function parent()
    {
    
        return $this->belongsTo(Category::class, 'parent_id');
    
    }

    public function products()
    {

        return $this->belongsToMany
        (
            related:Product::class,
            table:'category_product_relations'
        );
        
    }

    public function image()
    {

        return $this->hasOne(related:CategoryImage::class);
        
    }

    public function widgets()
    {

        return $this->belongsToMany
        (
            related: CategoryWidget::class,
            table: 'category_widget_category_relations',
        );

    }


    private function generateSlug()
    {

        $slug = str_replace(" ", "-", $this->name);
        $this->slug = $slug;
        
    }

}
