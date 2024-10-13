<?php

namespace App\Controllers;

use Timber\Timber;
use WP_Query;

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

        $args = [
            'post_type' => 'banner',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];

        $banner_query = new WP_Query($args);
        $banners = [];


        if ($banner_query->have_posts()) {
            while ($banner_query->have_posts()) {
                $banner_query->the_post();
                $image_id = get_the_ID();
             
                $image_ids = get_post_meta($image_id, '_mutiple_image_ids', true);

                $image_ids = array_map('trim', explode(',', $image_ids));

                $image_urls = [];
                foreach ($image_ids as $id) {
                    $url = wp_get_attachment_url($id, 'thumbnail', true);
                    if ($url) {
                        $image_urls[] = esc_url($url);
                    }
                }
                
                // Obtener los metadatos
                $banners_meta = [
                    'title' => get_the_title(),
                    'image_ids' => $image_ids,
                    'image_urls' => $image_urls,
                ];

                $banners[] = $banners_meta;
            }
        }

        $context['banners'] = $banners;

        wp_reset_postdata();

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
