<?php

namespace App\Support\ImageUpload;

use App\Models\Blog\Post;
use App\Models\Category;
use App\Models\Images\CategoryImage;
use App\Models\Images\PostImage;
use App\Models\Images\ProductImage;
use App\Models\ProductLine;
use Illuminate\Http\UploadedFile;

/**
 * Class for handling image upload operations including validation and uploading for products and posts.
 *
 * @property array $allowedMimeTypes List of allowed image MIME types.
 * @property int $maxFileSize Maximum file size allowed for image uploads (5MB limit).
 *
 * @method bool isValid(UploadedFile $file) Checks if the uploaded file is valid based on size and MIME type.
 * @method bool isValidSize(UploadedFile $file) Checks if the file size is within the allowed limit.
 * @method bool isValidMimeType(UploadedFile $file) Checks if the file MIME type is allowed.
 * @method ProductImage uploadImageForProduct(UploadedFile $file, ProductLine $productLine) Uploads an image for a product.
 * @method PostImage uploadImageForPost(UploadedFile $file, Post $post) Uploads an image for a post.
 * @method CategoryImage uploadImageForCategory(UploadedFile $file, Category $category) Uploads an image for a category.
 * @method void deleteCategoryImageBeforeUpload(Category $category) Removes the image related to a category.
 */
class ImageUploadService
{
    protected $allowedMimeTypes = [
        'image/jpeg', 'image/png', 'image/gif', 'image/webp',
        'image/jpg', 'image/psd',
    ];

    protected $maxFileSize = 5242880; // 5MB limit

    /**
     * Checks if the uploaded file is valid.
     *
     * @param UploadedFile $file The file to be validated.
     * @return bool True if the file is valid; otherwise, false.
     */
    public function isValid(UploadedFile $file): bool
    {
        return $file->isValid() &&
               $this->isValidSize($file) &&
               $this->isValidMimeType($file);
    }

    /**
     * Checks if the size of the uploaded file is valid based on the maximum allowed file size.
     *
     * @param UploadedFile $file The uploaded file to check the size for.
     * @return bool Returns true if the file size is within the allowed limit, false otherwise.
     */
    protected function isValidSize(UploadedFile $file): bool
    {
        return $file->getSize() <= $this->maxFileSize;
    }

    /**
     * Checks if the provided file has a valid MIME type.
     *
     * @param UploadedFile $file The file to check the MIME type for.
     * @return bool True if the MIME type is allowed, false otherwise.
     */
    protected function isValidMimeType(UploadedFile $file): bool
    {
        return in_array($file->getMimeType(), $this->allowedMimeTypes);
    }

    /**
     * Uploads an image for a Product Line.
     *
     * Retrieves the image content from the provided UploadedFile, along with the MIME type.
     * Creates a new ProductImage instance with the proper credentials.
     *
     * @param UploadedFile $file The file to upload as an image.
     * @param ProductLine $productLine The product line associated with the image.
     * @return ProductImage The created ProductImage instance.
     */
    public function uploadImageForProduct(UploadedFile $file, ProductLine $productLine): ProductImage
    {
        $imageBlob = file_get_contents($file);
        $mimeType = $file->getMimeType();

        return ProductImage::create([
            'alternative_text' => "Image of {$productLine->product->name}",
            'mime_type'        => $mimeType,
            'image'            => $imageBlob,
            'product_line_id'  => $productLine->id,
        ]);
    }

    /**
     * Uploads an image for a Post.
     *
     * Retrieves the image content from the provided UploadedFile, along with the MIME type.
     * Creates a new PostImage instance with the proper credentials.
     *
     * @param UploadedFile $file The uploaded file to be used as the image.
     * @param Post $post The post for which the image is being uploaded.
     * @return PostImage The created PostImage instance representing the uploaded image for the post.
     */
    public function uploadImageForPost(UploadedFile $file, Post $post): PostImage
    {
        $imageBlob = file_get_contents($file);
        $mimeType = $file->getMimeType();

        return PostImage::create([
            'alternative_text' => "Image of {$post->title}",
            'mime_type'        => $mimeType,
            'image'            => $imageBlob,
            'post_id'          => $post->id,
        ]);
    }

    /**
     * Uploads an image for a Category.
     *
     * Retrieves the image content from the provided UploadedFile, along with the MIME type.
     * Creates a new CategoryImage instance with the proper credentials.
     *
     * @param UploadedFile $file The file to upload as an image.
     * @param Category $category The Category associated with the image.
     * @return CategoryImage The created CategoryImage instance.
     */
    public function uploadImageForCategory(UploadedFile $file, Category $category): CategoryImage
    {
        $imageBlob = file_get_contents($file);
        $mimeType = $file->getMimeType();

        return CategoryImage::create([
            'alternative_text' => "Image of {$category->name}",
            'mime_type'        => $mimeType,
            'image'            => $imageBlob,
            'category_id'      => $category->id,
        ]);
    }

    /**
     * Removes the previous CategoryImage instance related to the Category object.
     *
     * Since CategoryImage & Category classes have a one to one relationship, a Category instance
     * can only have one Image; This method removes the previous CategoryImage instance related
     * to the Category, to make sure there is room for the new Image.
     *
     * Use this method before using @method uploadImageForCategory, to ensure a Category is only
     * connected to one CategoryImage instance.
     *
     * @param Category $category The Category object which its Image would be removed.
     * @return void
     */
    public function deleteCategoryImageBeforeUpload(Category $category): void
    {
        $image = CategoryImage::where('category_id', $category->id)->first();

        if ($image) {
            $image->delete();
        }
    }
}
