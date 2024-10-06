<?php

namespace App\Controllers;

use Timber\Timber;

class HomeController
{

    public function __construct()
    {
        if (is_front_page()) {
            $this->init();
        }
    }

    public function init()
    {
        $context = Timber::context();
        $context = $this->add_to_context($context);
        Timber::render('views/pages/page-home.twig', $context);
    }

    public function add_to_context($context)
    {
        $homepage_id = get_option('page_on_front');
        $context['home_main_title'] = get_post_meta($homepage_id, '_home_main_title', true);
        $context['home_main_description'] = get_post_meta($homepage_id, '_home_main_description', true);

        $context['home_texto_adicional'] = get_post_meta($homepage_id, '_home_texto_adicional', true);

        return $context;
    }

}

new HomeController();
