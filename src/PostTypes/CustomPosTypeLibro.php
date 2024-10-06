<?php

namespace App\PostTypes;

class CustomPosTypeLibro
{
    public static function register()
    {
        $labels = array(
            'name'               => _x('Libros', 'post type general name', 'textdomain'),
            'singular_name'      => _x('Libro', 'post type singular name', 'textdomain'),
            'menu_name'          => _x('Libros', 'admin menu', 'textdomain'),
            'name_admin_bar'     => _x('Libro', 'add new on admin bar', 'textdomain'),
            'add_new'            => _x('Añadir Nuevo', 'libro', 'textdomain'),
            'add_new_item'       => __('Añadir Nuevo Libro', 'textdomain'),
            'new_item'           => __('Nuevo Libro', 'textdomain'),
            'edit_item'          => __('Editar Libro', 'textdomain'),
            'view_item'          => __('Ver Libro', 'textdomain'),
            'all_items'          => __('Todos los Libros', 'textdomain'),
            'search_items'       => __('Buscar Libros', 'textdomain'),
            'parent_item_colon'  => __('Libros Padre:', 'textdomain'),
            'not_found'          => __('No se encontraron libros.', 'textdomain'),
            'not_found_in_trash' => __('No se encontraron libros en la basura.', 'textdomain'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'libro'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        );

        register_post_type('libro', $args);
    }
}
