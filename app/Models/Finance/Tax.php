<?php

namespace App\Models\Finance;

use App\Models\ProductLine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;


    public function products()
    {

        return $this->hasMany(ProductLine::class);
        
    }

    /**
     * Calculate the tax amount for a given price.
     *
     * @param float $price
     * @return float
     */
    public static function calculateTax(float $price): float
    {
        # Get the first (and only) Tax instance
        $tax = self::first();

        if (!$tax) {
            return 0;
        }

        $taxAmount = ($tax->percentage / 100) * $price;

        return $taxAmount;
    }
    
    /**
     * Boot method for the Tax model.
     * 
     * Ensures only one instance of Tax can exist.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (self::count() > 0) {
                return false;
            }
        });
    }
}
