<?php

namespace App\Models\Images;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryImage extends Model
{ 

    use HasFactory;
    

    protected $fillable = [
        'alternative_text',
        'mime_type',
        'image',
        'category_id',
    ];

    protected $guarded = [];


    public function product()
    {

        return $this->belongsTo(related:Category::class);
        
    }

}
