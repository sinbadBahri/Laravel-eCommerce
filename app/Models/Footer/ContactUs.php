<?php

namespace App\Models\Footer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;


    protected $table = 'contact_us_footer';

    protected $fillable = ['key', 'value', 'is_active'];

}
