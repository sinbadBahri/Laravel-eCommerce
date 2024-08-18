<?php

namespace App\Models\Footer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;


    protected $table = 'social_media_footer';

    protected $fillable = ['key', 'value', 'is_active'];


    public function footerName()
    {

        return "Social Medias";
        
    }
    
}