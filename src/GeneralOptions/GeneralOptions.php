<?php

namespace App\GeneralOptions;

class GeneralOptions
{
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
                submit_button('Guardar cambios');
                ?>
            </form>
        </div>
<?php
    }

    public static function register_settings()
    {
        // Registrar ajustes para la tab "Contact"
        register_setting('general_options_group', 'contact_name');
        register_setting('general_options_group', 'contact_email');
        register_setting('general_options_group', 'contact_phone');
        register_setting('general_options_group', 'contact_address');
        register_setting('general_options_group', 'contact_facebook');
        register_setting('general_options_group', 'contact_instagram');
        register_setting('general_options_group', 'contact_linkedin');

        // Registrar ajustes para la tab "Footer"
        register_setting('general_options_group', 'footer_text');
        register_setting('general_options_group', 'footer_instagram');
        register_setting('general_options_group', 'footer_facebook');
        register_setting('general_options_group', 'footer_email');
        register_setting('general_options_group', 'footer_phone');
        register_setting('general_options_group', 'footer_youtube');

        // Sección "Contact"
        add_settings_section(
            'contact_section',
            __('Contact Information', 'your-theme-textdomain'),
            null,
            'general_options'
        );

        add_settings_field(
            'contact_name',
            __('Name', 'your-theme-textdomain'),
            [__CLASS__, 'contact_name_html'],
            'general_options',
            'contact_section'
        );

        add_settings_field(
            'contact_email',
            __('Email', 'your-theme-textdomain'),
            [__CLASS__, 'contact_email_html'],
            'general_options',
            'contact_section'
        );

        add_settings_field(
            'contact_phone',
            __('Phone', 'your-theme-textdomain'),
            [__CLASS__, 'contact_phone_html'],
            'general_options',
            'contact_section'
        );

        add_settings_field(
            'contact_address',
            __('Address', 'your-theme-textdomain'),
            [__CLASS__, 'contact_address_html'],
            'general_options',
            'contact_section'
        );

        add_settings_field(
            'contact_facebook',
            __('Facebook', 'your-theme-textdomain'),
            [__CLASS__, 'contact_facebook_html'],
            'general_options',
            'contact_section'
        );

        add_settings_field(
            'contact_instagram',
            __('Instagram', 'your-theme-textdomain'),
            [__CLASS__, 'contact_instagram_html'],
            'general_options',
            'contact_section'
        );

        add_settings_field(
            'contact_linkedin',
            __('LinkedIn', 'your-theme-textdomain'),
            [__CLASS__, 'contact_linkedin_html'],
            'general_options',
            'contact_section'
        );

        // Sección "Footer"
        add_settings_section(
            'footer_section',
            __('Footer Information', 'your-theme-textdomain'),
            null,
            'general_options'
        );

        add_settings_field(
            'footer_text',
            __('Footer Text', 'your-theme-textdomain'),
            [__CLASS__, 'footer_text_html'],
            'general_options',
            'footer_section'
        );

        add_settings_field(
            'footer_instagram',
            __('Instagram', 'your-theme-textdomain'),
            [__CLASS__, 'footer_instagram_html'],
            'general_options',
            'footer_section'
        );

        add_settings_field(
            'footer_facebook',
            __('Facebook', 'your-theme-textdomain'),
            [__CLASS__, 'footer_facebook_html'],
            'general_options',
            'footer_section'
        );

        add_settings_field(
            'footer_email',
            __('Email', 'your-theme-textdomain'),
            [__CLASS__, 'footer_email_html'],
            'general_options',
            'footer_section'
        );

        add_settings_field(
            'footer_phone',
            __('Phone', 'your-theme-textdomain'),
            [__CLASS__, 'footer_phone_html'],
            'general_options',
            'footer_section'
        );

        add_settings_field(
            'footer_youtube',
            __('YouTube', 'your-theme-textdomain'),
            [__CLASS__, 'footer_youtube_html'],
            'general_options',
            'footer_section'
        );
    }

    // Métodos HTML para campos de la tab "Contact"
    public static function contact_name_html()
    {
        $value = get_option('contact_name');
        echo '<input type="text" name="contact_name" value="' . esc_attr($value) . '" />';
    }

    public static function contact_email_html()
    {
        $value = get_option('contact_email');
        echo '<input type="email" name="contact_email" value="' . esc_attr($value) . '" />';
    }

    public static function contact_phone_html()
    {
        $value = get_option('contact_phone');
        echo '<input type="text" name="contact_phone" value="' . esc_attr($value) . '" />';
    }

    public static function contact_address_html()
    {
        $value = get_option('contact_address');
        echo '<input type="text" name="contact_address" value="' . esc_attr($value) . '" />';
    }

    public static function contact_facebook_html()
    {
        $value = get_option('contact_facebook');
        echo '<input type="text" name="contact_facebook" value="' . esc_attr($value) . '" />';
    }

    public static function contact_instagram_html()
    {
        $value = get_option('contact_instagram');
        echo '<input type="text" name="contact_instagram" value="' . esc_attr($value) . '" />';
    }

    public static function contact_linkedin_html()
    {
        $value = get_option('contact_linkedin');
        echo '<input type="text" name="contact_linkedin" value="' . esc_attr($value) . '" />';
    }

    // Métodos HTML para campos de la tab "Footer"
    public static function footer_text_html()
    {
        $value = get_option('footer_text');
        echo '<input type="text" name="footer_text" value="' . esc_attr($value) . '" />';
    }

    public static function footer_instagram_html()
    {
        $value = get_option('footer_instagram');
        echo '<input type="text" name="footer_instagram" value="' . esc_attr($value) . '" />';
    }

    public static function footer_facebook_html()
    {
        $value = get_option('footer_facebook');
        echo '<input type="text" name="footer_facebook" value="' . esc_attr($value) . '" />';
    }

    public static function footer_email_html()
    {
        $value = get_option('footer_email');
        echo '<input type="email" name="footer_email" value="' . esc_attr($value) . '" />';
    }

    public static function footer_phone_html()
    {
        $value = get_option('footer_phone');
        echo '<input type="text" name="footer_phone" value="' . esc_attr($value) . '" />';
    }

    public static function footer_youtube_html()
    {
        $value = get_option('footer_youtube');
        echo '<input type="text" name="footer_youtube" value="' . esc_attr($value) . '" />';
    }
}
