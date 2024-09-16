<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Finance\Wallet;
use App\Models\Finance\WalletHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FinanceAndPaymentController extends Controller
{
    
    public function walletsView()
    {

        $wallets = Wallet::all();
        return view(view: 'admin.finance.allWallets', data: compact('wallets'));
        
    }

    public function walletHistoryView(int $wallet_id)
    {

        $wallet = Wallet::find($wallet_id);
        return view(view: 'admin.finance.showWallet', data: compact('wallet'));
        
    }

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

    public function ordersView()
    {

        return view(view: 'admin.finance.allOrders');

    }

    public function paymentsView()
    {

        return view(view: 'admin.finance.allPayments');  

    }

}
