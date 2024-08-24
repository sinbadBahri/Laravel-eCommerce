<?php 

namespace App\Support\Storage;

use App\Support\Storage\Contracts\StorageInterface;
use Countable;

/**
 * This Class representing a session storage implementation.
 *
 * This class implements the StorageInterface and Countable interfaces.
 * It provides methods to interact with session data such as getting, setting,
 * checking existence, unsetting, and clearing data.
 */
class SessionStorage implements StorageInterface, Countable
{

    private $bucket;

    public function __construct($bucket = 'default')
    {

        $this->bucket = $bucket;
    
    }

    /**
     * Get the value from the session storage based on the provided index.
     *
     * @param mixed $index The index of the value to retrieve from the session storage.
     * @return mixed The value stored in the session storage corresponding to the provided index.
     */
    public function get($index)
    {

        return session()->get($this->bucket . '.' . $index);
        
    }

    /**
     * Set a value in the session storage at the specified index.
     *
     * @param string $index The index where the value will be stored
     * @param mixed $value The value to be stored
     * @return void
     */
    public function set($index, $value)
    {

        return session()->put($this->bucket . '.' . $index, $value);
        
    }

    /**
     * Get all data stored in the session bucket.
     *
     * @return mixed The data stored in the session bucket.
     */
    public function all()
    {

        return session()->get($this->bucket);
        
    }

    /**
     * Check if a specific index exists in the session storage.
     *
     * @param string $index The index to check for existence
     * @return bool True if the index exists, false otherwise
     */
    public function exists($index)
    {

        return session()->has($this->bucket . '.'. $index);
        
    }

    /**
     * Unset a value from the session storage based on the provided index.
     *
     * @param string $index The index of the value to unset
     * @return void
     */
    public function unset($index)
    {

        return session()->forget($this->bucket . '.'. $index);
        
    }

    /**
     * Clears the value stored in the session bucket.
     */   
    public function clear()
    {

        return session()->forget($this->bucket);

    }

    /**
     * Returns the count of all items stored in the session storage bucket.
     *
     * If the storage is empty, it returns 0.
     * 
     * @return int The count of items in the session storage bucket.
     */
    public function count(): int
    {
        if (!$this->all() == null)
        {

            return count($this->all());
            
        }

        return 0;
    }

}