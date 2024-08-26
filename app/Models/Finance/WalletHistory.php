<?php

namespace App\Models\Finance;

use App\Exceptions\InactiveWalletException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    use HasFactory;

    protected $fillable = ['wallet_id', 'amount'];

    public function wallet()
    {

        return $this->belongsTo(Wallet::class);
        
    }

    protected static function booted()
    {
        static::created(function ($walletHistory) {
            
            $wallet = Wallet::find($walletHistory->wallet_id);

            if (!$wallet->is_active) {
                throw new InactiveWalletException();
            }

            $wallet->balance += $walletHistory->amount;

            $wallet->save();
        });
    }
}
