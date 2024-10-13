<?php

namespace App\Metaboxs;

use PhpOffice\PhpWord\IOFactory;

class UploadDocWordMetabox
{
    // Inicializar el metabox y registrar las rutas REST
    public static function init()
    {
        add_action('add_meta_boxes', [self::class, 'add_document_metabox']);
        add_action('rest_api_init', [self::class, 'register_rest_routes']);
    }

    // Añadir el metabox
    public static function add_document_metabox()
    {
        if (!current_user_can('upload_files')) {
            return;
        }

        add_meta_box(
            'document_word_upload_file',
            __('Upload Document (.docx)', 'textdomain'),
            [self::class, 'render_metabox'],
            'document_word',
            'normal',
            'high'
        );
    }

    // Renderizar el contenido del metabox
    public static function render_metabox($post)
    {
        wp_nonce_field('upload_doc_word_nonce', 'document_upload_nonce');
?>
        <div class="container">
            <input type="file" name="document_word_upload_file" accept=".docx">
            <button class="button" id="upload_doc_word_btn" type="button">Upload file</button>
            <div id="upload_result"></div>
            <div class="preview" id="html_preview"></div>
            <button class="button" id="delete_doc_word_btn" type="button">Delete</button>
        </div>

        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const uploadButton = document.getElementById('upload_doc_word_btn');
                const deleteButton = document.getElementById('delete_doc_word_btn');
                const fileInput = document.querySelector("input[name='document_word_upload_file']");
                const postId = '<?php echo $post->ID; ?>';

                uploadButton.addEventListener('click', async function() {
                    if (!fileInput.files.length) {
                        alert('Please select a file.');
                        return;
                    }

                    const file = fileInput.files[0];
                    if (!file) {
                        alert('Please select a file.');
                        return;
                    }

                    const nonce = document.querySelector("input[name='document_upload_nonce']").value;
                    const formData = new FormData();

                    formData.append('document', file);
                    formData.append('document_upload_nonce', nonce);

                    const response = await fetch(`/wp-json/documentos/v1/upload-document/${postId}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-WP-Nonce': nonce,
                        }
                    });

                    const result = await response.json();

                    if (response.ok) {
                        document.getElementById('html_preview').innerHTML = result.html_content;
                        alert('Document uploaded and converted successfully.');
                    } else {
                        alert(result.message || 'An error occurred.');
                    }
                });

                deleteButton.addEventListener('click', async function() {
                    const response = await fetch(`/wp-json/documentos/v1/delete-document/${postId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-WP-Nonce': document.querySelector("input[name='document_upload_nonce']").value,
                        }
                    });

                    const result = await response.json();
                    if (response.ok) {
                        document.getElementById('html_preview').innerHTML = '';
                        alert('Document deleted successfully.');
                    } else {
                        alert(result.message || 'An error occurred.');
                    }
                });
            });
        </script>

        <style>
            .container {
                display: flex;
                flex-direction: column;
                gap: 2rem;
            }


            input[type="file"] {
                background-color: #007cba;
                color: #fff;
                border: none;
                padding: 0.5rem 1rem;
                cursor: pointer;
                border-radius: 5px;
                font-size: 1rem;
                transition: background-color 0.3s ease;
            }


            input[type="file"]::-webkit-file-upload-button {
                background-color: #007cba;
                color: #fff;
                border: none;
                padding: 0.5rem 1rem;
                cursor: pointer;
                border-radius: 5px;
                font-size: 1rem;
                transition: background-color 0.3s ease;
            }


            input[type="file"]::-webkit-file-upload-button:hover {
                background-color: #005a9c;
            }


            input[type="file"]::-ms-browse {
                background-color: #007cba;
                color: #fff;
                border: none;
                padding: 0.5rem 1rem;
                cursor: pointer;
                border-radius: 5px;
                font-size: 1rem;
                transition: background-color 0.3s ease;
            }


            input[type="file"]::-ms-browse:hover {
                background-color: #005a9c;
            }


            .upload-file-container {
                display: flex;
                gap: 1rem;
            }


            .upload-file-container input[type="file"] {
                width: 200px;
            }


            .preview {
                border: 1px solid #ddd;
                padding: 1rem;
            }


            .button {
                padding: 0.5rem 1rem;
                background-color: #007cba;
                color: #fff;
                border: none;
                cursor: pointer;
            }
        </style>

<?php
    }

    // Registrar las rutas REST para la subida y eliminación de documentos
    public static function register_rest_routes()
    {

        register_rest_route('documentos/v1', '/upload-document/(?P<id>\d+)', [
            'methods' => 'POST',
            'callback' => [self::class, 'handle_document_upload'],
            'permission_callback' => function () {
                $can_upload = current_user_can('upload_files');
                error_log('User can upload files: ' . ($can_upload ? 'Yes' : 'No'));
                return $can_upload;
            },
        ]);

        register_rest_route('documentos/v1', '/delete-document/(?P<id>\d+)', [
            'methods' => 'DELETE',
            'callback' => [self::class, 'handle_document_delete'],
            'permission_callback' => function () {
                return current_user_can('upload_files');
            },
        ]);
    }

    // Manejar la subida del archivo y conversión a HTML
    public static function handle_document_upload(\WP_REST_Request $request)
    {
        $post_id = $request->get_param('id');
        if (!isset($_FILES['document']) || empty($_FILES['document']['name'])) {
            return new \WP_Error('no_file', 'No file uploaded', ['status' => 400]);
        }

        // Verificar nonce
        if (!wp_verify_nonce($request->get_param('document_upload_nonce'), 'upload_doc_word_nonce')) {
            return new \WP_Error('invalid_nonce', 'Nonce verification failed', ['status' => 403]);
        }

        if (!current_user_can('upload_files')) {
            return new \WP_Error('permission_denied', 'You do not have permission to upload files.', ['status' => 403]);
        }


        // Subir el archivo
        $file = $_FILES['document'];
        $upload = wp_handle_upload($file, ['test_form' => false]);

        if (isset($upload['error'])) {
            return new \WP_Error('upload_failed', $upload['error'], ['status' => 500]);
        }

        // Convertir a HTML
        if (pathinfo($upload['file'], PATHINFO_EXTENSION) !== 'docx') {
            return new \WP_Error('invalid_file_type', 'Only .docx files are allowed', ['status' => 400]);
        }

        $html_content = self::convert_word_to_html($upload['file']);
        if (!$html_content) {
            return new \WP_Error('conversion_failed', 'Failed to convert document to HTML', ['status' => 500]);
        }

        update_post_meta($post_id, '_document_word_upload', $upload['url']);
        update_post_meta($post_id, '_document_word_html', $html_content);

        return rest_ensure_response(['html_content' => $html_content]);
    }

    // Manejar la eliminación del documento
    public static function handle_document_delete(\WP_REST_Request $request)
    {
        $post_id = $request->get_param('id');

        // Verificar nonce
        if (!wp_verify_nonce($request->get_header('X-WP-Nonce'), 'upload_doc_word_nonce')) {
            return new \WP_Error('invalid_nonce', 'Nonce verification failed', ['status' => 403]);
        }

        // Eliminar los metadatos asociados
        delete_post_meta($post_id, '_document_word_upload');
        delete_post_meta($post_id, '_document_word_html');

        return rest_ensure_response(['message' => 'Document deleted successfully']);
    }

    // Convertir un archivo Word a HTML utilizando PHPWord
    public static function convert_word_to_html($file_path)
    {
        $phpWord = IOFactory::load($file_path, 'Word2007');
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');

        ob_start();
        $htmlWriter->save('php://output');
        $html_content = ob_get_clean();

        return $html_content;
    }
}
