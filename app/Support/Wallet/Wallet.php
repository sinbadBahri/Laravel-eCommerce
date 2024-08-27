<?php

namespace App\Support\Wallet;

use App\Models\Finance\Payment;
use App\Models\Finance\WalletHistory;
use App\Support\Basket\Basket;
use Illuminate\Http\RedirectResponse;
use Tymon\JWTAuth\Facades\JWTAuth;


/**
 * Wallet class handles user wallet operations such as processing payments,
 * updating wallet balance, and managing payment details.
 *
 * This class interacts with the user's wallet, basket, and payment history
 * to ensure smooth financial transactions within the application.
 */
class Wallet
{

    private $userWallet;
    private $basket;


    public function __construct(Basket $basket)
    {

        $this->userWallet = JWTAuth::user()->wallet;
        $this->basket = $basket;

    }

    /**
     * The Process of a payment transaction.
     *
     * Checks if the user's wallet is active and has sufficient balance to cover the payment amount.
     * Updates the user's balance and payment status accordingly.
     * Clears the basket after a successful payment.
     *
     * @param Payment $payment The payment object to process.
     * @return RedirectResponse A redirect response based on the payment outcome.
     */
    public function pay(Payment $payment): RedirectResponse
    {
        
        if($this->userWallet->is_active)
        {

            if($payment->amount <= $this->userWallet->balance)
            {
                
                $this->updateUserBalance($payment);
                $this->updateUserPayment($payment);
                
                $this->basket->clear();
                
                return redirect('/basket')->with('success', '200');
                
            }
            return redirect('/basket')->with("error","Your Balance is not enough");

        }

        return redirect('/basket')->with('error', "Your Wallet is not Active");
    }


    /**
     * Updates the user's wallet balance by creating a new entry in the WalletHistory table.
     *
     * @param Payment $payment The payment object containing the amount to deduct from the user's wallet balance.
     * @return void
     */
    private function updateUserBalance(Payment $payment)
    {

        WalletHistory::create([
            'wallet_id' => $this->userWallet->id,
            'amount'=> -$payment->amount,
        ]);
        
    }

    /**
     * Updates the payment details for a given Payment object.
     *
     * Generates a random reference number for the payment transaction,
     * sets the payment status to 1 -> ('complete'), and saves the updated payment object.
     *
     * @param Payment $payment The Payment object to update
     * @return void
     */
    private function updateUserPayment(Payment $payment)
    {

        $payment->ref_num = bin2hex(rand());
        $payment->status = 1;
        $payment->save();
        
    }

}