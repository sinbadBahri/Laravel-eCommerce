<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceAndPaymentController extends Controller
{
    
    public function walletsView()
    {

        return view(view: 'admin.finance.allWallets');
        
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
