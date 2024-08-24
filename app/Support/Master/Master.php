<?php

namespace App\Support\Master;



class Master
{

    protected $navbar;
    
    protected $footer;


    public function __construct(Navbar $navbar, Footer $footer)
    {
        
        $this->navbar = $navbar;

        $this->footer = $footer;

    }

    public function setNavbarAndFooter()
    {

        # Navbar
        $cartItems = $this->navbar->getCartTotal();
        $genres = $this->navbar->genres;

        # Footer
        $footerCollection = $this->footer->getAllFooterItems();

        $content = [

            # Navbar
            'cartItems'=> $cartItems,
            'genres' => $genres,

            # Footer
            'footerCollection' => $footerCollection,
        ];

        return $content;

        
    }
}