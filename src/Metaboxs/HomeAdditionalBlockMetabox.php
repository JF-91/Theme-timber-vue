<?php

namespace App\Metaboxs;

class HomeAdditionalBlockMetabox
{
    public static function init()
    {
        add_action('add_meta_boxes', [__CLASS__, 'register_metabox']);
        add_action('save_post', [__CLASS__, 'save_metabox']);
    }

    public static function register_metabox()
    {
        $post_id = get_option('page_on_front'); // Obtener la ID de la página Home
        if ($post_id) {
            add_meta_box(
                'home_metabox',          // ID del metabox
                'Contenido adicional',   // Título del metabox
                [__CLASS__, 'show_metabox'], // Callback para mostrar el contenido
                'page',                  // Tipo de post (en este caso, página)
                'normal',                // Posición en la pantalla
                'high',                  // Prioridad
                null,                    // Argumentos adicionales
                $post_id                 // Página específica (Home)
            );
        }
    }

    public static function show_metabox($post)
    {
        $valor = get_post_meta($post->ID, '_home_texto_adicional', true);
?>
        <label for="home_texto_adicional">Texto adicional para la Home:</label>
        <input type="text" id="home_texto_adicional" name="home_texto_adicional" value="<?php echo esc_attr($valor); ?>" size="25" />
        <button type="button" id="btn_home_texto_adicional">Limpiar</button>
        <script>
            document.getElementById('btn_home_texto_adicional').addEventListener('click', function() {
                document.getElementById('home_texto_adicional').value = '';
            });
        </script>
<?php
    }

    public static function save_metabox($post_id)
    {
        if (array_key_exists('home_texto_adicional', $_POST)) {
            update_post_meta(
                $post_id,
                '_home_texto_adicional',
                sanitize_text_field($_POST['home_texto_adicional'])
            );
        }
    }
}

