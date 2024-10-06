<?php

namespace App\Metaboxs;

class HomeBlockMetabox
{

    // Inicializar el metabox
    public static function init()
    {
        add_action('add_meta_boxes', [self::class, 'add_home_metabox']);
        add_action('save_post', [self::class, 'save_home_metabox']);
    }

    // Añadir el metabox a la página de inicio
    public static function add_home_metabox()
    {
        $post_id = get_option('page_on_front');
        if (!$post_id) {
            return;
        }

        add_meta_box(
            'home_main_block', // ID único
            __('Home Main Block', domain: 'your-theme-textdomain'), // Título
            [self::class, 'render_metabox'], // Callback para mostrar el contenido
            'page', // Tipo de pantalla
            'normal', // Contexto
            'high', // Prioridad
            ['post_id' => $post_id] // Argumentos adicionales
        );
    }

    // Renderizar el contenido del metabox
    public static function render_metabox($post, $metabox)
    {
        $post_id = $metabox['args']['post_id'];
        $main_title = get_post_meta($post_id, '_home_main_title', true);
        $main_description = get_post_meta($post_id, '_home_main_description', true);

        // Campo para el título principal
        echo '<label for="home_main_title">' . __('Main Title', 'your-theme-textdomain') . '</label>';
        echo '<input type="text" name="home_main_title" value="' . esc_attr($main_title) . '" class="widefat" />';

        // Campo para la descripción principal
        echo '<label for="home_main_description">' . __('Main Description', 'your-theme-textdomain') . '</label>';
        echo '<textarea name="home_main_description" class="widefat">' . esc_attr($main_description) . '</textarea>';

        // Nonce para verificar
        wp_nonce_field('save_home_main_block', 'home_main_block_nonce');
    }

    // Guardar los valores del metabox
    public static function save_home_metabox($post_id)
    {
        if (!isset($_POST['home_main_block_nonce']) || !wp_verify_nonce($_POST['home_main_block_nonce'], 'save_home_main_block')) {
            return;
        }

        // Verificar permisos
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['home_main_title'])) {
            update_post_meta($post_id, '_home_main_title', sanitize_text_field($_POST['home_main_title']));
        }

        if (isset($_POST['home_main_description'])) {
            update_post_meta($post_id, '_home_main_description', sanitize_textarea_field($_POST['home_main_description']));
        }
    }
}
