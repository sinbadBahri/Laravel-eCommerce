<?php

namespace App\Models;

use App\Models\Finance\Discount;
use App\Models\Finance\Order;
use App\Models\Finance\Payment;
use App\Models\Finance\Tax;
use App\Models\Images\ProductImage;
use App\Models\Widgets\ProductWidget;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLine extends Model
{
    use HasFactory;


    protected $fillable = [

        'product_id',
        'price',
        'stock_qty',
        'sku',
        'is_available',

    ];


    public function product()
    {

        return $this->belongsTo(
                related: Product::class,
                foreignKey: 'product_id',
            );
    }

    public function getProductType()
    {
        return $this->product->productType;
    }

    public function attributeValues()
    {

        return $this->belongsToMany(

                related: AttributeValue::class,
                table: 'product_line_attr_values',

            );
    }


    public function images()
    {

        return $this->hasMany(related: ProductImage::class);
    }

    public function orders()
    {

        return $this->belongsToMany(
                related: Order::class,
                table: 'order_items',
            )
            ->withPivot('quantity')
            ->withTimestamps();
    }


    public function widgets()
    {

        return $this->belongsToMany(
                related: ProductWidget::class,
                table: 'product_widget_product_line',
            );
    }

    /**
     * Check if the product line has enough stock quantity.
     *
     * @param int $quantity The quantity to check against the stock quantity
     * @return bool True if the stock quantity is greater than or equal to the given quantity.
     */
    public function hasStock(int $quantity)
    {

        return $this->stock_qty >= $quantity;
    }

    public function discount()
    {

        return $this->belongsTo(Discount::class);
    }

    /**
     * Get the final price of the product line after applying any available discount.
     *
     * If a discount code is provided, attempts to add the discount based on the code;
     * otherwise, uses the default discount associated with the product line.
     * Calculates the final price after applying the discount, if applicable.
     *
     * @param string|null $discount_code The discount code to apply (optional)
     * @return float The final price of the product line after applying discounts
     */
    public function getFinalPrice(string $discount_code = null): float
    {

        if (! $discount = $this->addDiscountFromCode($discount_code)) {
            $discount = $this->discount;
        }

        return $this->calculateDiscountedPrice($discount);
    }

    /**
     * Returns a Discount instance based on the provided discount code.
     *
     * Checks if the discount is still active.
     * Also checks if the authenticated user is allowed to use this discount.
     *
     * @param string $code The discount code to search for.
     * @return Discount|null The discount if found and valid; otherwise, null.
     */
    private function addDiscountFromCode(string $code = null)
    {

        $discount = Discount::where('code', $code)->first();

        if ($discount) {
            if ($discount->valid_until > now() && $discount->isValidForUser()) {
                return $discount;
            }
        }
    }

    /**
     * Calculates the discounted price for the product line.
     *
     * Checks if the given discount is valid and still active.
     *
     * If a discount is applicable, calculates the discounted price based on
     * the discount percentage and maximum amount.
     *
     * If no valid discount is available, returns the original price.
     *
     * @param Discount $discount The discount to apply.
     * @return float The final price considering the discount.
     */
    private function calculateDiscountedPrice(Discount $discount = null): float
    {

        $price = $this->price;

        if ($discount && $discount->valid_until > now()) {

            return $price - $discount->getDiscountAmount(price: $price);
        }

        return $price;
    }

    public function tax()
    {

        return $this->belongsTo(Tax::class);
    }


    /**
     * Boot method for the ProductLine model.
     *
     * Sets up a creating event listener to automatically assign a Tax to each ProductLine instance.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $tax = Tax::first();
            $model->tax()->associate($tax);
        });
    }

    /**
     * This Static method is responsible for updating the stock-quantity of product lines
     * after each payment transaction.
     *
     * @param Payment $payment finds which products to update regarding this payment.
     * @return void
     */
    public static function updateStock(Payment $payment)
    {

        $product_lines = $payment->order->products;


        foreach ($product_lines as $product_line) {

            $product_line->stock_qty -= $product_line->pivot->quantity;
            $product_line->save();
        }
    }
}
