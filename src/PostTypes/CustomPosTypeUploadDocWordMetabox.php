<?php

namespace App\PostTypes;

class CustomPosTypeUploadDocWordMetabox
{
    public static function register()
    {
        $labels = array(
            'name'               => _x('Document word', 'post type general name', 'textdomain'),
            'singular_name'      => _x('Document word', 'post type singular name', 'textdomain'),
            'menu_name'          => _x('Document word', 'admin menu', 'textdomain'),
            'name_admin_bar'     => _x('Document word', 'add new on admin bar', 'textdomain'),
            'add_new'            => _x('Añadir Nuevo', 'Document', 'textdomain'),
            'add_new_item'       => __('Añadir Nuevo Document word', 'textdomain'),
            'new_item'           => __('Nuevo Document word', 'textdomain'),
            'edit_item'          => __('Editar Document', 'textdomain'),
            'view_item'          => __('Ver Document word', 'textdomain'),
            'all_items'          => __('Todos los Document word', 'textdomain'),
            'search_items'       => __('Buscar Document word', 'textdomain'),
            'parent_item_colon'  => __('Document word Padre:', 'textdomain'),
            'not_found'          => __('No se encontraron Document word.', 'textdomain'),
            'not_found_in_trash' => __('No se encontraron Document word en la basura.', 'textdomain'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_rest'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'document_word'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        );

        register_post_type('document_word', $args);
    }
}
