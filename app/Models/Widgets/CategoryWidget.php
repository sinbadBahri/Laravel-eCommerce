<?php

namespace App\Models\Widgets;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryWidget extends Model
{
    use HasFactory;

    protected $table = 'product_widgets';

    protected $fillable = ['title', 'is_active'];
    

    public function categories()
    {

        return $this->belongsToMany
        (
            related: Category::class,
            table: 'category_widget_category_relations',
        );

    }

}
