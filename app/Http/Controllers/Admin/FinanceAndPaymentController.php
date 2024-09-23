<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Finance\Discount;
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

        return $this->respondWithSuccess("Wallet status updated successfully");

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

        return $this->respondWithSuccess("Wallet history added successfully");

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

    /**
     * Handles the request to store a new Discount instance.
     *
     * This method validates the incoming request, checks for invalid discount code logic,
     * prepares the data for storing, and finally creates the discount record in the database.
     *
     * @param Request $request  The HTTP request containing the discount data.
     * @return JsonResponse A JSON response indicating success or failure.
     */
    public function storeDiscount(Request $request): JsonResponse
    {
        $this->validateDiscount($request);

        if ($this->hasInvalidCode($request))
        {
            return $this->respondWithError(
                'Code cannot be null when "Have Code" is checked.'
            );
        }

        $discountData = $this->prepareDiscountData($request);

        Discount::create($discountData);

        return $this->respondWithSuccess("New Discount Defined");
    }

    /**
     * Validates the Discount request data.
     *
     * This method checks if the incoming request has valid fields for creating a discount.
     * Required fields include 'title' and 'percentage', while other fields such as
     * 'description', 'valid_until', 'max_amount', and 'code' are optional. It also validates
     * if the discount code is unique.
     *
     * @param Request $request  The HTTP request containing the discount data.
     * @return void
     */
    private function validateDiscount(Request $request): void
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'percentage'  => 'required|integer|min:1|max:100',
            'description' => 'nullable|string',
            'valid_until' => 'nullable|date',
            'max_amount'  => 'nullable|numeric',
            'code'        => 'nullable|string|unique:discounts,code',
            'have_code'   => 'nullable|boolean',
        ]);
    }

    /**
     * Checks if the discount code is invalid when "Have Code" is checked.
     *
     * This method ensures that when the `have_code` boolean is true, a discount code must be provided.
     * If no code is present, it returns true, indicating invalid input.
     *
     * @param Request $request  The HTTP request containing the discount data.
     * @return bool Returns true if the discount code is missing while `have_code` is true, otherwise false.
     */
    private function hasInvalidCode(Request $request): bool
    {
        return $request->boolean('have_code') && !$request->filled('code');
    }

    /**
     * Prepares the Discount data for database storage.
     *
     * This method collects the validated request input and organizes it into an array ready for
     * storing in the database. It converts the `have_code` field to a boolean value.
     *
     * @param Request $request  The HTTP request containing the discount data.
     * @return array An associative array of discount data to be used for creating a record.
     */
    private function prepareDiscountData(Request $request): array
    {
        return [
            'title'       => $request->title,
            'description' => $request->description,
            'percentage'  => $request->percentage,
            'valid_until' => $request->valid_until,
            'max_amount'  => $request->max_amount,
            'code'        => $request->code,
            'have_code'   => $request->boolean('have_code'),
        ];
    }

    /**
     * Returns a JSON response indicating success.
     *
     * This method provides a uniform way to respond to successful operations.
     *
     * @param string $message  The error message to be included in the response.
     * @return JsonResponse A JSON response with a success message.
     */
    private function respondWithSuccess(string $message): JsonResponse
    {
        return response()->json(['success' => true, 'message' => $message]);
    }

    /**
     * Returns a JSON response indicating an error.
     *
     * This method provides a uniform way to respond to errors.
     *
     * @param string $message  The error message to be included in the response.
     * @return JsonResponse A JSON response with an error message.
     */
    private function respondWithError(string $message): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message]);
    }

}
