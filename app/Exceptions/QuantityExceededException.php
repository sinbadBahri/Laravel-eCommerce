<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuantityExceededException extends Exception
{

    public function render(Request $request): Response
    {
        $status = 400;
        $error = "Something went wrong. It seems there are no more products available!";
        $help = "Contact the admin if you seek large volume products";

        return response(["error" => $error, "help" => $help], $status);
    }

}
