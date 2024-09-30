<?php

namespace App\Models\Images;

use App\Models\Blog\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{

    protected $fillable = [
        'alternative_text',
        'mime_type',
        'image',
        'post_id',
    ];

    protected $guarded = [];


    public function product()
    {

        return $this->belongsTo(related: Post::class);
    }
}
