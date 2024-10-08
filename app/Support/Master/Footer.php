<?php

namespace App\Support\Master;

use App\Models\Footer\ContactUs;
use App\Models\Footer\Rivas;
use App\Models\Footer\SocialMedia;

/**
 * Class representing the Footer of the website.
 * 
 * This class manages the footer items such as Contact Us, Social Media etc.
 */
class Footer
{
    protected $contactUsItems;

    protected $socilaMediaItems;

    protected $rivasItems;


    public function __construct()
    {

        $this->contactUsItems = ContactUs::all();
        $this->socilaMediaItems = SocialMedia::all();
        $this->rivasItems = Rivas::all();

    }

    public function getAllFooterItems()
    {

        $footerCollection = [

            $this->contactUsItems->where('is_active', true)->all(),
            $this->socilaMediaItems->where('is_active', true)->all(),
            $this->rivasItems->where('is_active', true)->all(),

        ];

        return $footerCollection;
        
    }

}