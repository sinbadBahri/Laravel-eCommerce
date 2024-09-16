<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Finance\Order;
use App\Models\Finance\Payment;
use App\Models\Finance\Wallet;
use App\Models\Finance\WalletHistory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FinanceAndPaymentController extends Controller
{
    
    public function walletsView(): View
    {

        $wallets = Wallet::all();
        return view(view: 'admin.finance.allWallets', data: compact('wallets'));
        
    }

    public function walletHistoryView(int $wallet_id): View
    {

        $wallet = Wallet::find($wallet_id);
        return view(view: 'admin.finance.showWallet', data: compact('wallet'));
        
    }

    /**
     * Toggles the status of a wallet.
     *
     * Validates the 'is_active' field in the request.
     * Updates the status of the wallet with the provided ID(Weather the wallet is 
     * active or deactive).
     * Returns a JSON response indicating the success of the status update.
     *
     * @param Request $request The request object containing the wallet status.
     * @param int $wallet_id The ID of the wallet to update.
     * @return JsonResponse JSON response with a success message.
     */
    public function toggleStatus(Request $request, int $wallet_id): JsonResponse
    {

        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $wallet = Wallet::findOrFail($wallet_id);
        $wallet->is_active = $request->input('is_active');
        $wallet->save();

        return response()->json(['message' => 'Wallet status updated successfully.']);
    
    }

    /**
     * Creates a new instance of WalletHistory Class.
     * 
     * This Method updates the balance amount of a specific Wallet by creating
     * a new WalletHistory instance.
     *
     * @param Request $request The request object containing the amount to add to the wallet history.
     * @param int $wallet_id The ID of the wallet to add the history entry to.
     * @return JsonResponse A JSON response indicating the success of adding the wallet history.
     */
    public function addHistory(Request $request, int $wallet_id): JsonResponse
    {
        // dd("karim");
        $request->validate([
            'amount' => 'required|numeric',
        ]);
            
        WalletHistory::create([

            'wallet_id'=> $wallet_id,
            'amount'=> $request->amount,
        
        ]);

        return response()->json(['message' => 'Wallet history added successfully.']);

    }

    public function ordersView(): View
    {

        $orders = Order::all();
        return view(view: 'admin.finance.allOrders', data: compact('orders'));

    }

    public function paymentsView(): View
    {

        $payments = Payment::all();
        return view(view: 'admin.finance.allPayments', data: compact('payments'));  

    }

}
