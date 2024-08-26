<?php

namespace App\Models\Finance;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;


    public function user()
    {

        return $this->belongsTo(User::class);
        
    }

    public function histories()
    {

        return $this->hasMany(WalletHistory::class);
        
    }
}
