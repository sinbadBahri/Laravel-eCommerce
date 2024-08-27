<?php

namespace App\Support\Basket;

use App\Exceptions\QuantityExceededException;
use App\Models\Finance\Tax;
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
     * Removes a specific product line from the basket.
     */
    public function remove(int $id)
    {

        $this->storage->unset($id);
        
    }

    /**
     * Clears all product lines from the basket.
     */
    public function clear()
    {

        $this->storage->clear();
        
    }

    /**
     * Returns the total count of items in the basket.
     * 
     * Warning: This method does not return quantities of items.
     * 
     * @return int
     */
    public function itemCount(): int
    {

        return $this->storage->count();
        
    }

    /**
     * Retrieves all product lines from the basket.
     * 
     * If there are product line IDs in the storage, retrieves the corresponding products
     * and sets the quantity for each product based on the stored quantity in the basket.
     * 
     * @return array|null The array of products with updated quantities, or null if no products are found.
     */
    public function allProducts()
    {
        if($product_line_ids = $this->storage->all())
        {

            $products = ProductLine::find(array_keys($product_line_ids));
            
            foreach ($products as $product)
            {
                $product->quantity = $this->get($product)['quantity'];
            }
    
            return $products;
        }
    }

    /**
     * Calculates the tax-free total price of all products in the basket.
     */
    public function getTaxFreeTotal(): float
    {

        $total = 0;

        if ($products = $this->allProducts())
        {

            foreach ($products as $product)
            {
                $total += $product->price * $product->quantity;
            }
        
        }

        return $total;
        
    }

    /**
     * Calculates the total price with discount applied.
     *
     * This method iterates over all products in the basket, calculates the final price of each product
     * with the provided discount code, and accumulates the total price with discount.
     *
     * @param string|null $code The discount code to apply (optional).
     * @return float The total price with discount applied.
     */
    public function getTotalWithDiscount(string $code = null): float
    {

        $totalWithDiscount = 0;
        
        if ($products = $this->allProducts())
        {

            foreach ($products as $product)
            {
                $totalWithDiscount += $product->getFinalPrice($code) * $product->quantity;
            }
        
        }

        return $totalWithDiscount;
        
    }

    /**
     * Returns the total amount with tax included.
     *
     * This method calculates the total amount with tax by adding the total amount with discount to the tax amount.
     *
     * @return float The total amount with tax included.
     */
    public function getTotalWithTax(): float
    {

        $totalWithDiscount = $this->getTotalWithDiscount();

        return $totalWithDiscount + Tax::calculateTax($totalWithDiscount);
        
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