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
        $post_id = get_queried_object_id();
        
        $context['about_text'] = get_post_meta($post_id, '_about_text', true);
        $context['about_textarea'] = get_post_meta($post_id, '_about_textarea', true);
        $context['about_image'] = get_post_meta($post_id, '_about_image', true);
        $context['about_button_1'] = get_post_meta($post_id, '_about_button_1', true);
        $context['about_button_2'] = get_post_meta($post_id, '_about_button_2', true);
        $context['about_link_button_1'] = get_post_meta($post_id, '_about_link_button_1', true);
        $context['about_link_button_2'] = get_post_meta($post_id, '_about_link_button_2', true);
        return $context;
    }
}

new AboutController();