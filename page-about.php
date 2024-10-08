<?php

namespace App\Controllers;

use Timber\Timber;
use WP_Query;

class AboutController
{

    public function __construct()
    {
        if (is_page('about')) {
            $this->init();
        } else {
            error_log('No se está en la página About');
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
        error_log('Post ID: ' . $post_id);

        $args = [
            'post_type' => 'document',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];

        $documents_query = new WP_Query($args);
        $documents = [];

        if ($documents_query->have_posts()) {
            while ($documents_query->have_posts()) {
                $documents_query->the_post();
                $doc_id = get_the_ID();

                // Obtener los metadatos
                $document_meta = [
                    'title' => get_the_title(),
                    'document_url' => get_post_meta($doc_id, '_document_upload', true),
                    'document_html' => get_post_meta($doc_id, '_document_html', true),
                ];

                $documents[] = $document_meta;
            }
        }

        // Guardar los documentos en el contexto
        $context['documents'] = $documents;

        wp_reset_postdata();

      
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