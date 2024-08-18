<?php

namespace App\Models\Images;

use App\Models\ProductLine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{

    protected $fillable = [
        'alternative_text',
        'mime_type',
        'image',
        'product_line_id',
    ];

    # Disable mass-assignment protection for these fields
    protected $guarded = [];

    public function product()
    {

        return $this->belongsTo(related:ProductLine::class);
        
    }

}
