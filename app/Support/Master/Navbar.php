<?php

namespace App\Support\Master;

use App\Models\Blog\Genre;
use App\Support\Basket\Basket;

/**
 * Class representing a navigation bar.
 *
 * This class manages the data of the navigation bar which
 * needs to be pushed to Blade Files.
 */
class Navbar
{

    public $genres;
    private $basket;
    

    public function __construct(Basket $basket)
    {

        $this->genres = Genre::all();
        $this->basket = $basket;

    }

    public function getCartTotal()
    {

        return $this->basket->itemCount();
     
    }
    
}