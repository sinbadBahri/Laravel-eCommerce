<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmptyBasketException extends Exception
{

    public function render(Request $request): Response
    {
        $status = 400;
        $error = "Your Basket is Empty";
        $help = "First add some products to your Cart and then attempt to pay for them.";

        return response(["error" => $error, "help" => $help], $status);
    }

}
