<?php

namespace App\PostTypes;

class CustomPosTypeUploadDocument
{
    public static function register()
    {
        $labels = array(
            'name'               => _x('Document', 'post type general name', 'textdomain'),
            'singular_name'      => _x('Document', 'post type singular name', 'textdomain'),
            'menu_name'          => _x('Document', 'admin menu', 'textdomain'),
            'name_admin_bar'     => _x('Document', 'add new on admin bar', 'textdomain'),
            'add_new'            => _x('Añadir Nuevo', 'Document', 'textdomain'),
            'add_new_item'       => __('Añadir Nuevo Document', 'textdomain'),
            'new_item'           => __('Nuevo Document', 'textdomain'),
            'edit_item'          => __('Editar Document', 'textdomain'),
            'view_item'          => __('Ver Document', 'textdomain'),
            'all_items'          => __('Todos los Document', 'textdomain'),
            'search_items'       => __('Buscar Document', 'textdomain'),
            'parent_item_colon'  => __('Document Padre:', 'textdomain'),
            'not_found'          => __('No se encontraron Document.', 'textdomain'),
            'not_found_in_trash' => __('No se encontraron Document en la basura.', 'textdomain'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'document'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        );

        register_post_type('document', $args);
    }
}
