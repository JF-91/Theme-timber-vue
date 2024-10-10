<?php

namespace App\Metaboxs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DocumentUploadMetabox
{
    // Inicializar el metabox
    public static function init()
    {
        add_action('add_meta_boxes', [self::class, 'add_document_metabox']);
        add_action('wp_ajax_save_document_upload', [self::class, 'save_document_metabox']);
        add_action('wp_ajax_delete_document_upload', [self::class, 'delete_document_metabox']);
    }

    // Añadir el metabox
    public static function add_document_metabox()
    {
        if (!current_user_can('upload_files')) {
            return; // El usuario no tiene permiso para subir archivos
        }

        add_meta_box(
            'document_upload',
            __('Upload Document', 'textdomain'),
            [self::class, 'render_metabox'],
            'document',
            'normal',
            'high'
        );
    }

    public static function delete_document_metabox()
    {
        if (!check_ajax_referer('save_document_upload', 'document_upload_nonce', false)) {
            wp_send_json_error('Nonce inválido.');
            wp_die();
        }

        $post_id = intval($_POST['post_id']);
        if (!$post_id) {
            wp_send_json_error('ID del post no válido.');
            wp_die();
        }

        // Eliminar el documento
        delete_post_meta($post_id, '_document_upload');
        delete_post_meta($post_id, '_document_html');

        wp_send_json_success('El documento ha sido eliminado.');
        wp_die();
    }

    // Renderizar el contenido del metabox
    public static function render_metabox($post)
    {
        $document = get_post_meta($post->ID, '_document_upload', true);
        $html_content = get_post_meta($post->ID, '_document_html', true); // Obtener el contenido HTML convertido
        $is_link_visible = get_post_meta($post->ID, '_is_link_visible', true); // Recuperar el estado del checkbox


        echo '<form id="document-upload-form" method="post" enctype="multipart/form-data">';
        echo '<label for="document_upload">' . __('Upload PDF Document', 'textdomain') . '</label>';
        echo '<input type="file" name="document_upload" accept=".pdf" class="widefat" />';
        echo '<br> <br>';
        echo '<label for="is_link_visible">' . __('Link visible', 'textdomain') . '</label>';
        echo '<input type="checkbox" name="is_link_visible" value="1" class="input-checkbox"' . checked($is_link_visible, '1', false) . '/>';
        echo '<br><br>';

        echo '<button type="button" id="upload-button">' . __('Upload', 'textdomain') . '</button>'; // Botón para subir


        if ($document) {
            echo '<p>' . __('Uploaded Document:', 'textdomain') . ' <a href="' . esc_url($document) . '" target="_blank">' . basename($document) . '</a></p>';
            echo '<button type="button" id="delete-button">' . __('Delete', 'textdomain') . '</button>'; // Botón para eliminar

        }

        // Mostrar el contenido HTML convertido si existe
        if ($html_content) {
            echo '<h3>' . __('Converted HTML Content', 'textdomain') . '</h3>';
            echo '<div>' . wp_kses_post($html_content) . '</div>'; // Sanitiza y muestra el contenido HTML
        }

        wp_nonce_field('save_document_upload', 'document_upload_nonce');
        echo '</form>';

        // JavaScript para manejar la carga del archivo usando Axios
?>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            document.getElementById("upload-button").addEventListener("click", function() {
                var fileInput = document.querySelector("input[name='document_upload']");
                if (fileInput.files.length === 0) {
                    alert("Por favor, selecciona un archivo.");
                    return;
                }

                var formData = new FormData();
                formData.append('action', 'save_document_upload');
                formData.append('post_id', <?php echo $post->ID; ?>);
                formData.append('document_upload', fileInput.files[0]);
                formData.append('document_upload_nonce', jQuery('input[name="document_upload_nonce"]').val());

                var checkbox = document.querySelector("input[name='is_link_visible']");
                formData.append('is_link_visible', checkbox.checked ? '1' : '0'); // Envío del estado del checkbox

                axios.post("<?php echo admin_url('admin-ajax.php'); ?>", formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function(response) {
                        if (response.data.success) {
                            alert("Documento subido y convertido correctamente.");
                            location.reload(); // Recargar la página para ver el nuevo documento
                        } else {
                            alert("Error: " + (response.data.message || 'Error desconocido.'));
                        }
                    })
                    .catch(function(error) {
                        alert("Error en la solicitud: " + (error.response ? error.response.data.message : error.message));
                    });
            });

            // Manejar la eliminación del documento
            document.getElementById("delete-button")?.addEventListener("click", function() {
                if (!confirm("¿Estás seguro de que deseas eliminar este documento?")) {
                    return;
                }

                var formData = new FormData();
                formData.append('action', 'delete_document_upload');
                formData.append('post_id', <?php echo $post->ID; ?>);
                formData.append('document_upload_nonce', jQuery('input[name="document_upload_nonce"]').val());

                axios.post("<?php echo admin_url('admin-ajax.php'); ?>", formData)
                    .then(function(response) {
                        if (response.data.success) {
                            alert("Documento eliminado correctamente.");
                            location.reload(); // Recargar la página para ver los cambios
                        } else {
                            alert("Error: " + (response.data.message || 'Error desconocido.'));
                        }
                    })
                    .catch(function(error) {
                        alert("Error en la solicitud: " + (error.response ? error.response.data.message : error.message));
                    });
            });
        </script>
<?php
    }

    // Guardar los valores del metabox
    public static function save_document_metabox()
    {
        error_log('Guardando documento metabox');


        if (!check_ajax_referer('save_document_upload', 'document_upload_nonce', false)) {
            wp_send_json_error('Nonce inválido.');
            wp_die();
        }


        $post_id = intval($_POST['post_id']);
        if (!$post_id) {
            wp_send_json_error('ID del post no válido.');
            wp_die();
        }

        if (empty($_FILES['document_upload']['name'])) {
            wp_send_json_error('No se ha recibido ningún archivo.');
            wp_die();
        }

        $file = $_FILES['document_upload'];
        error_log('Archivo recibido: ' . print_r($file, true));

        // Manejo de la subida del archivo
        $upload = wp_handle_upload($file, ['test_form' => false]);

        if (isset($upload['error'])) {
            error_log('Error al subir el documento: ' . $upload['error']);
            wp_send_json_error('Error al subir el documento: ' . $upload['error']);
            wp_die();
        }

        update_post_meta($post_id, '_document_upload', $upload['url']);
        $html_content = self::convert_document_to_html($upload['file']);

        if (!empty($html_content)) {
            update_post_meta($post_id, '_document_html', $html_content);
            wp_send_json_success('El documento se ha subido y convertido a HTML.');
        } else {
            wp_send_json_error('La conversión a HTML falló o no se generó contenido.');
        }

        $is_link_visible = isset($_POST['is_link_visible']) ? '1' : '0'; // '1' si está marcado, '0' si no
        update_post_meta($post_id, '_is_link_visible', $is_link_visible);

        wp_die();
    }

    // Convertir el documento a HTML utilizando ConvertAPI  
    public static function convert_document_to_html($file_path)
    {
        $client = new Client();
        $html_content = '';

        // Obtener la clave API de las opciones de WordPress
        $convertApiKey = get_option('convertapi_api_key');

        // Verificar que la clave API esté configurada
        if (empty($convertApiKey)) {
            error_log('La clave API de ConvertAPI no está configurada.');
            return '';
        }

        try {
            // Leer el contenido del archivo y codificarlo en Base64
            $file_data = file_get_contents($file_path);
            $base64_file = base64_encode($file_data);
            $file_name = basename($file_path);

            // Crear un trabajo de conversión de PDF a HTML
            $response = $client->post('https://v2.convertapi.com/convert/pdf/to/html', [
                'json' => [
                    'Parameters' => [
                        [
                            'Name' => 'File',
                            'FileValue' => [
                                'Name' => $file_name,
                                'Data' => $base64_file,
                            ],
                        ],
                        [
                            'Name' => 'StoreFile',
                            'Value' => true,
                        ],
                    ],
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $convertApiKey,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // Agregar un registro para ver la respuesta completa
            error_log('Respuesta de ConvertAPI: ' . print_r($data, true));

            if (isset($data['Files']) && !empty($data['Files'])) {
                $html_file_url = $data['Files'][0]['Url'];

                $html_content = file_get_contents($html_file_url);

                error_log('El documento se ha convertido a HTML con éxito: ' . $html_content);
            } else {
                error_log('No se pudo obtener el contenido HTML: ' . json_encode($data));
            }
        } catch (RequestException $e) {
            error_log('ConvertAPI error: ' . $e->getMessage());
            if ($e->hasResponse()) {
                error_log('Response: ' . $e->getResponse()->getBody());
            }
        }

        return $html_content;
    }
}
