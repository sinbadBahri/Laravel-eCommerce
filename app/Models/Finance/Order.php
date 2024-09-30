<?php

namespace App\Models\Finance;

use App\Models\ProductLine;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'code', 'total'];

    public function products()
    {

        return $this->belongsToMany
        (
            related: ProductLine::class,
            table: 'order_items',
        )
        ->withPivot('quantity')
        ->withTimestamps();
        
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
