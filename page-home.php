<?php

namespace App\Controllers;

use Timber\Timber;

class HomeController
{

    public function __construct()
    {
        if (is_page('home')) {
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
        $post_id = get_queried_object_id();
        error_log('Post ID: ' . $post_id);

        $context['home_text'] = get_post_meta($post_id, '_home_text', true);
        $context['home_textarea'] = get_post_meta($post_id, '_home_textarea', true);
        $context['home_image'] = get_post_meta($post_id, '_home_image', true);
        $context['home_button_1'] = get_post_meta($post_id, '_home_button_1', true);
        $context['home_button_2'] = get_post_meta($post_id, '_home_button_2', true);
        $context['home_link_button_1'] = get_post_meta($post_id, '_home_link_button_1', true);
        $context['home_link_button_2'] = get_post_meta($post_id, '_home_link_button_2', true);

        return $context;
    }

}

new HomeController();
