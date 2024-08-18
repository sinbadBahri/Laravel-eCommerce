<?php

namespace App\Models\Footer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rivas extends Model
{
    use HasFactory;


    protected $table = 'rivas_footer';

    protected $fillable = ['key', 'value', 'is_active'];

}
