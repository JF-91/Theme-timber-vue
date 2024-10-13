<?php

namespace App\PostTypes;

class CustomPosTypeBanner
{
    public static function register()
    {
        $labels = array(
            'name'               => _x('Banner', 'post type general name', 'textdomain'),
            'singular_name'      => _x('Banner', 'post type singular name', 'textdomain'),
            'menu_name'          => _x('Banner', 'admin menu', 'textdomain'),
            'name_admin_bar'     => _x('Banner', 'add new on admin bar', 'textdomain'),
            'add_new'            => _x('Añadir Nuevo', 'Banner', 'textdomain'),
            'add_new_item'       => __('Añadir Nuevo Banner', 'textdomain'),
            'new_item'           => __('Nuevo Banner', 'textdomain'),
            'edit_item'          => __('Editar Banner', 'textdomain'),
            'view_item'          => __('Ver Banner', 'textdomain'),
            'all_items'          => __('Todos los Banner', 'textdomain'),
            'search_items'       => __('Buscar Banner', 'textdomain'),
            'parent_item_colon'  => __('Banner Padre:', 'textdomain'),
            'not_found'          => __('No se encontraron Banner.', 'textdomain'),
            'not_found_in_trash' => __('No se encontraron Banner en la basura.', 'textdomain'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'banner'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        );

        register_post_type('banner', $args);
    }
}
