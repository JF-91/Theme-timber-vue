<?php

namespace App\Metaboxs;

class MultipleImageUploadMetabox
{
    public static function init()
    {
        add_action('add_meta_boxes', [__CLASS__, 'register_metabox']);
        add_action('save_post', [__CLASS__, 'save_metabox']);
    }

    public static function register_metabox()
    {
        add_meta_box(
            'multiple_image_upload_metabox',          // ID del metabox
            'Multiple Image upload',   // Título del metabox
            [__CLASS__, 'show_metabox'], // Callback para mostrar el contenido
            'banner',                  // Tipo de post (en este caso, página)
            'normal',                // Posición en la pantalla
            'high',                  // Prioridad
            null,                    // Argumentos adicionales
        );
    }

    public static function show_metabox($post)
    {
        // Obtener las imágenes guardadas
        $image_ids = get_post_meta($post->ID, '_mutiple_image_ids', true);
?>
        <label class="multiple-images-upload-label" for="mutiple_image_ids">Additional iamges for Banner:</label>
        <input type="hidden" id="mutiple_image_ids" name="mutiple_image_ids" value="<?php echo esc_attr($image_ids); ?>" />

        <div id="multiple_images_container" class="multiple-upload-images-preview-container">
            <!-- Aquí aparecerán las imágenes seleccionadas -->
            <?php
            if ($image_ids) {
                $image_ids_array = explode(',', $image_ids);

                foreach ($image_ids_array as $image_id) {
                    $image_url = wp_get_attachment_url($image_id);
                    echo '<div class="image-preview">';
                    echo '<img class="multiple-images-upload-image" src="' . esc_url($image_url) . '" />';
                    echo '<button type="button" class="remove-image-button" data-id="' . $image_id . '">x</button>';
                    echo '</div>';
                }
            }
            ?>
        </div>

        <div class="buttons-container">
            <button class="button-multiple-upload-image" type="button" id="upload_images_button">Subir imágenes</button>
            <button class="button-multiple-upload-image" type="button" id="remove_images_button">Eliminar imágenes</button>
        </div>

        <style>
            .multiple-upload-images-preview-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(min(100%, 200px), 1fr));
                gap: 1rem;
            }

            .multiple-images-upload-label {
                display: block;
                font-size: 18px;
                line-height: 26px;
                margin-bottom: 32px;
            }

            .image-preview {
                display: flex;
                gap: 1rem;
                flex-direction: column-reverse;
                align-items: center;
                justify-content: center;
            }

            .multiple-images-upload-image {
                max-width: 150px;
                min-height: auto;
                border-radius: 12px;
                object-fit: cover;
            }

            .remove-image-button {
                display: flex;
                align-items: center;
                background-color: black;
                color: white;
                padding: 4px 8px;
                border: none;
                border-radius: 50%;
                cursor: pointer;
            }

            .buttons-container {
                display: flex;
                gap: 16px;
                margin-top: 32px;
            }

            .button-multiple-upload-image {
                background-color: black;
                color: white;
                padding: 12px;
                border-radius: 12px;

            }
        </style>

        <script>
            jQuery(document).ready(function($) {
                var frame;

                // Evento para abrir el media uploader y seleccionar imágenes
                $('#upload_images_button').on('click', function(e) {
                    e.preventDefault();

                    if (frame) {
                        frame.open();
                        return;
                    }

                    frame = wp.media({
                        title: 'Seleccionar Imágenes',
                        button: {
                            text: 'Usar estas imágenes'
                        },
                        multiple: true
                    });

                    frame.on('select', function() {
                        var attachment_ids = [];

                        // Obtener las imágenes ya existentes
                        var existing_ids = $('#mutiple_image_ids').val();
                        if (existing_ids) {
                            attachment_ids = existing_ids.split(',');
                        }

                        var attachments = frame.state().get('selection').toJSON();

                        // Añadir nuevas imágenes sin reemplazar las existentes
                        attachments.forEach(function(attachment) {
                            attachment_ids.push(attachment.id);

                            // Añadir la imagen al contenedor con el botón de eliminar
                            $('#multiple_images_container').append(
                                '<div class="image-preview" data-image-id="' + attachment.id + '">' +
                                '<img src="' + attachment.url + '" style="max-width: 150px; margin-right: 10px;" />' +
                                '<button type="button" class="remove-image-button" data-id="' + attachment.id + '">x</button>' +
                                '</div>'
                            );
                        });

                        // Actualizar el campo oculto con los nuevos IDs
                        $('#mutiple_image_ids').val(attachment_ids.join(','));
                    });

                    frame.open();
                });

                // Eliminar imagen individualmente
                $(document).on('click', '.remove-image-button', function() {
                    var image_id = $(this).data('id');
                    var attachment_ids = $('#mutiple_image_ids').val().split(',');

                    // Remover el ID de la imagen del array
                    attachment_ids = attachment_ids.filter(function(id) {
                        return id != image_id;
                    });

                    // Actualizar el campo oculto con los nuevos IDs
                    $('#mutiple_image_ids').val(attachment_ids.join(','));

                    // Eliminar la imagen del contenedor de la vista previa
                    $(this).closest('.image-preview').remove();
                });

                // Eliminar todas las imágenes
                $('#remove_images_button').on('click', function() {
                    $('#mutiple_image_ids').val('');
                    $('#multiple_images_container').html('');
                });
            });
        </script>

<?php
    }

    public static function save_metabox($post_id)
    {
        if (array_key_exists('mutiple_image_ids', $_POST)) {
            update_post_meta(
                $post_id,
                '_mutiple_image_ids',
                sanitize_text_field($_POST['mutiple_image_ids'])
            );
        }
    }
}
