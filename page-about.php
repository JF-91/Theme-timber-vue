<?php

namespace App\Controllers;

use Timber\Timber;

class AboutController
{

    public function __construct()
    {
        if (is_page('about')) {
            $this->init();
        }
    }

    public function init()
    {
        $context = Timber::context();
        $context = $this->add_to_context($context);
        Timber::render('views/pages/page-about.twig', $context);
    }

    public function add_to_context($context)
    {
        
        return $context;
    }
}

new AboutController();