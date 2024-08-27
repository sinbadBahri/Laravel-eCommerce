<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use HasFactory;
    

    /**
     * Defines a one-to-one relationship with the User model.
     */
    public function user()
    {

        return $this->belongsTo(User::class);
        
    }
}
