<?php

namespace App\Models;

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
}
