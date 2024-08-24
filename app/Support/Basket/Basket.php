<?php

namespace App\Support\Basket;

use App\Exceptions\QuantityExceededException;
use App\Models\ProductLine;
use App\Support\Storage\Contracts\StorageInterface;

class Basket
{

    private $storage;

    /**
     * Constructor for the Basket class.
     *
     * Initializes the storage property with the provided StorageInterface instance.
     *
     * @param StorageInterface $storageInterface The storage interface instance to be used.
     */
    public function __construct(StorageInterface $storageInterface)
    {

        $this->storage = $storageInterface;
    
    }

    /**
     * Adds a product line to the basket with the specified quantity.
     * 
     * If the product line already exists in the basket,
     * the quantity is updated by adding the new quantity.
     *
     * @param ProductLine $productLine The product_line object for adding to the basket.
     * @param int $quantity The quantity of the product line to add.
     * @return void
     */
    public function add(ProductLine $productLine, int $quantity)
    {
        
        if ($this->exists($productLine)) 
        {

            $quantity = $this->get($productLine)['quantity'] + $quantity;

        }

        $this->update($productLine, $quantity);
        
    }

    /**
     * Returns the quantity of a specific product line from the storage.
     */
    public function get(ProductLine $productLine)
    {

        return $this->storage->get($productLine->id);
        
    }

    /**
     * Checks if a product line exists in the basket storage.
     */
    public function exists(ProductLine $productLine)
    {

        return $this->storage->exists($productLine->id);
        
    }


    /**
     * Updates the quantity of a product line in the basket.
     *
     * Checks if the new quantity exceeds the available stock.
     * If the quantity exceeds the stock, a QuantityExceededException is thrown.
     *
     * @param ProductLine $productLine The product line to update.
     * @param int $quantity The new quantity to set.
     * @throws QuantityExceededException If the new quantity exceeds the available stock.
     */
    private function update(ProductLine $productLine, int $quantity)
    {

        if (!$productLine->hasStock(quantity: $quantity))
        {
            throw new QuantityExceededException();
        }

        $this->storage->set($productLine->id, [

            "quantity"=> $quantity,
        
        ]);
        
    }
}