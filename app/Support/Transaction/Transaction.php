<?php

namespace App\Support\Transaction;

use App\Models\Finance\Order;
use App\Models\Finance\Payment;
use App\Support\Basket\Basket;
use App\Support\Wallet\Wallet;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class Transaction
{

    private $request;
    private $wallet;
    private $basket;


    public function __construct(Request $request, Wallet $wallet, Basket $basket)
    {

        $this->request = $request;
        $this->wallet = $wallet;
        $this->basket = $basket;

    }

    /**
     * Performs the checkout process by calling other methods.
     * 
     * @return mixed The result of the checkout process.
     */
    public function checkout()
    {
        $order = $this->makeOrder();
        $payment = $this->makePayment($order);

        return $this->checkoutMethod($payment);
        
    }

    /**
     * Creates a new order for the user.
     *
     * Generates a new order with user ID, a unique code, and total amount including tax.
     * Attaches each product in the basket to the order with its quantity.
     *
     * @return Order The newly created order.
     */
    private function makeOrder()
    {
        
        $order = Order::create([
            'user_id' => JWTAuth::user()->id,
            'code' => bin2hex(rand()),
            'total' => $this->basket->getTotalWithTax(), 
        ]);

        foreach ($this->basket->allProducts() as $product)
        {
            $order->products()
                    ->attach($product, ['quantity' => $product->quantity]);
        }

        return $order;
    
    } 

    /**
     * Create a new payment with the given order.
     *
     * The 'method'  would be either 'wallet' or 'bank'.
     * The 'ref_num' value would be "ref_num" by default untill later actions.
     * The Gateway is set to null because we haven't already defined gateway methods.
     * 
     * @param Order $order The order for which the payment is being made.
     * @return Payment The created payment object.
     */
    private function makePayment(Order $order)
    {
        
        $payment = Payment::create([
            'order_id' => $order->id,
            'method' => $this->request->method,
            'gateway' => null, # will change later
            'ref_num' => "ref_num",
            'amount' => $order->total,
        ]);

        return $payment;
        
    }

    /**
     * Refers to other methods of the same class for continuing the purchase process.
     */
    private function checkoutMethod(Payment $payment)
    {

        return match ($this->request->method) {
            'wallet' => $this->walletPay($payment),
            'bank'   => $this->gateway($payment),
        };
        
    }

    private function walletPay(Payment $payment)
    {
        return $this->wallet->pay($payment);
    }

    private function gateway($payment)
    {
        dd('This Part is not Ready');
    }
    
}