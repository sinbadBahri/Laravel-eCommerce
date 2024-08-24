<?php

namespace App\Support\Basket;

use App\Models\ProductLine;
use App\Support\Storage\Contracts\StorageInterface;

class Basket
{

    private $storage;

    public function __construct(StorageInterface $storageInterface)
    {

        $this->storage = $storageInterface;
    
    }

    public function add(ProductLine $productLine, int $quantity)
    {

        if ($this->exists($productLine)) 
        {

            $quantity = $this->get($productLine->quantity) + $quantity;

        }

        $this->storage->set($productLine->id, [

            "quantity"=> $quantity,
        
        ]);
        
    }

    public function get(ProductLine $productLine)
    {

        return $this->storage->get($productLine->id);
        
    }

    public function exists(ProductLine $productLine)
    {

        return $this->storage->exists($productLine->id);
        
    }
}