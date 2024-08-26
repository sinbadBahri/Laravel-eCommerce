<?php

namespace App\Models\Finance;

use App\Models\ProductLine;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Facades\JWTAuth;

class Discount extends Model
{
    use HasFactory;


    public function products()
    {

        return $this->hasMany(ProductLine::class);
        
    }

    public function users()
    {

        return $this->belongsToMany
        (
            related: User::class,
            table: "discount_user_relations",
        );
        
    }

    /**
     * Checks if the discount is valid for the currently authenticated user.
     */
    public function isValidForUser(): bool
    {

        $user_id = JWTAuth::user()->id;

        return $this->users()->where("user_id", $user_id)->exists();
        
    }

    /**
     * Returns the discount amount based on the given price.
     * 
     * Calculates the discounted price based on the discount percentage and maximum amount.
     *
     * @param int $price The original price before discount.
     * @return float The calculated discount amount.
     */
    public function getDiscountAmount(int $price): float
    {

        $discountAmount = ($price <= $this->max_amount)
        ? ($price * $this->percentage) / 100
        : ($this->max_amount * $this->percentage) / 100;

        return $discountAmount;
        
    }
}
