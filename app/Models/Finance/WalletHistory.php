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

    /**
     * This Event automatically updates the balance in the Wallet model
     * whenever a WalletHistory is created.
     * 
     * Also checks if the wallet is active before updating the balance.
     * If the wallet is inactive, throws the custom InactiveWalletException.
     */
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
