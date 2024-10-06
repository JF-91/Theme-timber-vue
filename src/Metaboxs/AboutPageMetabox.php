<?php

namespace App\Metaboxs;

class AboutPageMetabox
{
    // Inicializar el metabox
    public static function init()
    {
        add_action('add_meta_boxes', [self::class, 'add_about_metabox']);
        add_action('save_post', [self::class, 'save_about_metabox']);
    }

    // Añadir el metabox a la página "About"
    public static function add_about_metabox()
    {
        // Asumiendo que la página "About" tiene el ID 2; ajusta esto según tu configuración
        $post_id = 2; // Reemplaza 2 con el ID real de tu página "About"

        add_meta_box(
            'about_page_metabox', // ID único
            __('About Page Fields', 'your-theme-textdomain'), // Título
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
        // Obtener los valores guardados
        $text = get_post_meta($post->ID, '_about_text', true);
        $textarea = get_post_meta($post->ID, '_about_textarea', true);
        $image = get_post_meta($post->ID, '_about_image', true);
        $button1 = get_post_meta($post->ID, '_about_button_1', true);
        $button2 = get_post_meta($post->ID, '_about_button_2', true);

        // Campo para el texto
        echo '<label for="about_text">' . __('Text', 'your-theme-textdomain') . '</label>';
        echo '<input type="text" name="about_text" value="' . esc_attr($text) . '" class="widefat" />';

        // Campo para el textarea
        echo '<label for="about_textarea">' . __('Textarea', 'your-theme-textdomain') . '</label>';
        echo '<textarea name="about_textarea" class="widefat">' . esc_textarea($textarea) . '</textarea>';

        // Campo para la imagen
        echo '<label for="about_image">' . __('Image', 'your-theme-textdomain') . '</label>';
        echo '<input type="hidden" name="about_image" value="' . esc_attr($image) . '" class="widefat" id="about_image_field" width="100" height="100" />';
        echo '<img id="about_image_preview" src="' . esc_url($image) . '" style="max-width: 100%; height: auto; margin-top: 10px;" />';

        // Cambié el botón a tipo "button"
        echo '<button type="button" class="button upload_image_button">' . __('Upload Image', 'your-theme-textdomain') . '</button>';

        // Campos para los botones
        echo '<label for="about_button_1">' . __('Button 1', 'your-theme-textdomain') . '</label>';
        echo '<input type="text" name="about_button_1" value="' . esc_attr($button1) . '" class="widefat" />';

        echo '<label for="about_button_2">' . __('Button 2', 'your-theme-textdomain') . '</label>';
        echo '<input type="text" name="about_button_2" value="' . esc_attr($button2) . '" class="widefat" />';

        // Nonce para verificar
        wp_nonce_field('save_about_page_fields', 'about_page_nonce');
    }

    // Guardar los valores del metabox
    public static function save_about_metabox($post_id)
    {
        // Verificar nonce
        if (!isset($_POST['about_page_nonce']) || !wp_verify_nonce($_POST['about_page_nonce'], 'save_about_page_fields')) {
            return;
        }

        // Verificar permisos
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Guardar los campos
        if (isset($_POST['about_text'])) {
            update_post_meta($post_id, '_about_text', sanitize_text_field($_POST['about_text']));
        }

        if (isset($_POST['about_textarea'])) {
            update_post_meta($post_id, '_about_textarea', sanitize_textarea_field($_POST['about_textarea']));
        }

        if (isset($_POST['about_image'])) {
            update_post_meta($post_id, '_about_image', sanitize_text_field($_POST['about_image']));
        }

        if (isset($_POST['about_button_1'])) {
            update_post_meta($post_id, '_about_button_1', sanitize_text_field($_POST['about_button_1']));
        }

        if (isset($_POST['about_button_2'])) {
            update_post_meta($post_id, '_about_button_2', sanitize_text_field($_POST['about_button_2']));
        }
    }
}

// Inicializa la clase al llamarla
AboutPageMetabox::init();
