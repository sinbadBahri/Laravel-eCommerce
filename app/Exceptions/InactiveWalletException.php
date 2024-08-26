<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InactiveWalletException extends Exception
{

    public function render(Request $request): Response
    {
        $status = 400;
        $error = "Something went wrong. It seems your wallet is inactive and cannot be updated.!";
        $help = "Contact the admin for helping you reactivate your wallet";

        return response(["error" => $error, "help" => $help], $status);
    }

}
