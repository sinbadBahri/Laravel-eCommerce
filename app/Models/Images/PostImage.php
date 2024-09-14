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

        return $this->belongsTo(related:Post::class);
        
    }

    /**
     * Validates an image file based on specific criteria.
     *
     * @param $file The image file to be validated.
     * @return bool True if the image file passes all validation checks, false otherwise.
     */
    public static function validateImage($file)
    {

        $allowedMimeTypes = [
            'image/jpeg', 'image/png',
            'image/gif', 'image/webp',
            'image/jpg', 'image/psd',
        ];

        # Check if the file is valid
        if (!$file->isValid())
        {
            return false;
        }

        # Check the MIME type
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $allowedMimeTypes))
        {
            return false;
        }

        # Check the file size (must be <= 1MB)
        $fileSize = $file->getSize();
        if ($fileSize > 1048576) # 1MB = 1048576 bytes
        { 
            return false;
        }

        return true;
        
    }

}