<?php

namespace App\GeneralOptions;

class GeneralOptions
{
    private const CONTACT_FIELDS = [
        'contact_name'     => 'Name',
        'contact_email'    => 'Email',
        'contact_phone'    => 'Phone',
        'contact_address'  => 'Address',
        'contact_facebook' => 'Facebook',
        'contact_instagram' => 'Instagram',
        'contact_linkedin' => 'LinkedIn',
    ];

    private const FOOTER_FIELDS = [
        'footer_text'      => 'Footer Text',
        'footer_instagram' => 'Instagram',
        'footer_facebook'  => 'Facebook',
        'footer_email'     => 'Email',
        'footer_phone'     => 'Phone',
        'footer_youtube'   => 'YouTube',
    ];

    public function __construct()
    {
        add_action('admin_menu', [__CLASS__, 'register_options_page']);
        add_action('admin_init', [__CLASS__, 'register_settings']);
    }

    public static function register_options_page()
    {
        add_menu_page(
            __('General Options', 'your-theme-textdomain'),
            __('General Options', 'your-theme-textdomain'),
            'manage_options',
            'general_options',
            [__CLASS__, 'options_page_html'],
            'dashicons-admin-generic',
            20
        );
    }

    public static function options_page_html()
    {
        if (!current_user_can('manage_options')) {
            return;
        }
?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('general_options_group');
                do_settings_sections('general_options');
                submit_button(__('Save Changes', 'your-theme-textdomain'));
                ?>
            </form>
        </div>
<?php
    }

    public static function register_settings()
    {
        // Registro de ajustes para Contact y Footer
        foreach (self::CONTACT_FIELDS as $key => $label) {
            register_setting('general_options_group', $key);
            add_settings_field($key, __($label, 'your-theme-textdomain'), [__CLASS__, "{$key}_html"], 'general_options', 'contact_section');
        }

        foreach (self::FOOTER_FIELDS as $key => $label) {
            register_setting('general_options_group', $key);
            add_settings_field($key, __($label, 'your-theme-textdomain'), [__CLASS__, "{$key}_html"], 'general_options', 'footer_section');
        }

        // Registro de ajustes para la API de ConvertAPI
        register_setting('general_options_group', 'convertapi_api_key', [
            'sanitize_callback' => [__CLASS__, 'sanitize_convertapi_api_key'],
        ]);

        // Secciones
        add_settings_section('contact_section', __('Contact Information', 'your-theme-textdomain'), null, 'general_options');
        add_settings_section('footer_section', __('Footer Information', 'your-theme-textdomain'), null, 'general_options');
        add_settings_section('api_section', __('ConvertAPI Settings', 'your-theme-textdomain'), null, 'general_options');

        // Campo para la API de ConvertAPI
        add_settings_field('convertapi_api_key', __('ConvertAPI API Key', 'your-theme-textdomain'), [__CLASS__, 'convertapi_api_key_html'], 'general_options', 'api_section');
    }

    // Métodos HTML para los campos
    public static function __callStatic($name, $arguments)
    {
        $key = strtolower(substr($name, 0, strrpos($name, '_html')));
        $value = get_option($key);
        $type = strpos($key, 'email') !== false ? 'email' : 'text'; // Determina el tipo de campo
        echo "<input type=\"$type\" name=\"$key\" value=\"" . esc_attr($value) . "\" />";
    }

    public static function convertapi_api_key_html()
    {
        $value = get_option('convertapi_api_key');
        echo '<input type="text" name="convertapi_api_key" value="' . esc_attr($value) . '" />';
    }

    public static function sanitize_convertapi_api_key($key)
    {
        return sanitize_text_field($key);
    }
}
