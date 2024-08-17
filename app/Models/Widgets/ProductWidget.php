<?php

namespace App\Models\Widgets;


use App\Models\ProductLine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProductWidget extends Model
{
    use HasFactory;

    protected $table = 'product_widgets';

    protected $fillable = ['title', 'is_active'];
    

    public function products()
    {

        return $this->belongsToMany
        (
            related: ProductLine::class,
            table: 'product_widget_product_line',
        );

    }

}
