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
        $home_page = get_page_by_path('home');
        if ($home_page) {
            $post_id = $home_page->ID;
        } else {
            return;
        }

        global $post;



        global $post;
        if ($post && $post->ID == $post_id) {
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
    }

    // Renderizar el contenido del metabox
    public static function render_metabox($post, $metabox)
    {
        // Obtener los valores guardados
        $text = get_post_meta($post->ID, '_home_text', true);
        $textarea = get_post_meta($post->ID, '_home_textarea', true);
        $image = get_post_meta($post->ID, '_home_image', true);
        $button1 = get_post_meta($post->ID, '_home_button_1', true);
        $button2 = get_post_meta($post->ID, '_home_button_2', true);
        $linkButton1 = get_post_meta($post->ID, '_home_link_button_1', true);
        $linkButton2 = get_post_meta($post->ID, '_home_link_button_2', true);

        // Campo para el texto
        echo '<label for="home_text">' . __('Text', 'your-theme-textdomain') . '</label>';
        echo '<input type="text" name="home_text" value="' . esc_attr($text) . '" class="widefat" />';

        // Campo para el textarea
        echo '<label for="home_textarea">' . __('Textarea', 'your-theme-textdomain') . '</label>';
        echo '<textarea name="home_textarea" class="widefat" rows="12" cols="100">' . esc_textarea($textarea) . '</textarea>';

        // Campo para la imagen
        echo '<label for="home_image" style="display: flex;">' . __('Image', 'your-theme-textdomain') . '</label>';
        echo '<input type="hidden" name="home_image" value="' . esc_attr($image) . '" class="widefat" id="upload_image_field" width="100" height="100" />';
        echo '<img id="upload_image_preview" src="' . esc_url($image) . '" style="max-width: 100%; height: 300px; margin-top: 10px;" />';

        // Cambié el botón a tipo "button"
        echo '<button type="button" class="button upload_image_button" style="display: flex;">' . __('Upload Image', 'your-theme-textdomain') . '</button>';

        // Campos para los botones y enlaces
        echo '<label for="home_button_1">' . __('Button 1', 'your-theme-textdomain') . '</label>';
        echo '<input type="text" name="home_button_1" value="' . esc_attr($button1) . '" class="widefat" />';

        echo '<label for="home_link_button_1">' . __('Link-button 1', 'your-theme-textdomain') . '</label>';
        echo '<input type="text" name="home_link_button_1" value="' . esc_attr($linkButton1) . '" class="widefat" />';

        echo '<label for="home_button_2">' . __('button 2', 'your-theme-textdomain') . '</label>';
        echo '<input type="text" name="home_button_2" value="' . esc_attr($button2) . '" class="widefat" />';

        echo '<label for="home_link_button_2">' . __('Link-button 2', 'your-theme-textdomain') . '</label>';
        echo '<input type="text" name="home_link_button_2" value="' . esc_attr($linkButton2) . '" class="widefat" />';

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

         // Guardar los campos
        if (isset($_POST['home_text'])) {
            update_post_meta($post_id, '_home_text', sanitize_text_field($_POST['home_text']));
        }

        if (isset($_POST['home_textarea'])) {
            update_post_meta($post_id, '_home_textarea', sanitize_text_field($_POST['home_textarea']));
        }

        if (isset($_POST['home_image'])) {
            update_post_meta($post_id, '_home_image', sanitize_text_field($_POST['home_image']));
        }

        if (isset($_POST['home_button_1'])) {
            update_post_meta($post_id, '_home_button_1', sanitize_text_field($_POST['home_button_1']));
        }

        if (isset($_POST['home_link_button_1'])) {
            update_post_meta($post_id, '_home_link_button_1', sanitize_text_field($_POST['home_link_button_1']));
        }

        if (isset($_POST['home_button_2'])) {
            update_post_meta($post_id, '_home_button_2', sanitize_text_field($_POST['home_button_2']));
        }

        if (isset($_POST['home_link_button_2'])) {
            update_post_meta($post_id, '_home_link_button_2', sanitize_text_field($_POST['home_link_button_2']));
        }
    }
}
