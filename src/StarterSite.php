<?php

namespace App;

use App\GeneralOptions\GeneralOptions;
use App\Metaboxs\AboutPageMetabox;
use App\Metaboxs\HomeAdditionalBlockMetabox;
use App\Metaboxs\HomeBlockMetabox;
use App\PostTypes\CustomPosTypeLibro;
use Timber\Post;
use Timber\Site;
use Timber\Timber;

/**
 * Class StarterSite
 */
class StarterSite extends Site
{
	public function __construct()
	{
		add_action('after_setup_theme', array($this, 'theme_supports'));
		add_action('init', array($this, 'register_post_types'));
		add_action('init', array($this, 'register_taxonomies'));
		add_action('init', array($this, 'register_metaboxes'));

		add_action('wp_enqueue_scripts', array($this, 'enqueue_custom_styles'));

		//site scripts
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

		//admin scripts
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));


		add_filter('timber/context', array($this, 'add_to_context'));
		add_filter('timber/twig', array($this, 'add_to_twig'));
		add_filter('timber/twig/environment/options', [$this, 'update_twig_environment_options']);

		add_filter('timber/meta/transform_value', '__return_true');

		//options
		$this->initialize_general_options();

		parent::__construct();
	}

	public function enqueue_custom_styles()
	{
		// wp_enqueue_style('custom-style', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0', 'all');
		wp_enqueue_style('custom-style', get_template_directory_uri() . '/dist/styles.css', array(), '1.0.0', 'all');
	}


	public function enqueue_admin_scripts()
	{
		wp_enqueue_media(); // Habilitar la biblioteca de medios
		wp_enqueue_script('jquery');

		// Encola el script del admin (subida de imágenes)
		wp_register_script('admin', get_template_directory_uri() . '/assets/scripts/admin.js', ['jquery'], '1.0.0', true);
		wp_enqueue_script('admin');
	}


	public function enqueue_scripts()
	{
		//this with webpack
		wp_enqueue_media(); // Habilitar la biblioteca de medios
		wp_enqueue_script('jquery');

		wp_register_script('site', get_template_directory_uri() . '/dist/bundle.js', ['jquery'], '1.0.0', true);
		wp_enqueue_script('site'); // Encola el script
	}

	public function enqueue_frontend_scripts()
	{
		// Encola el script generado por Webpack
		wp_enqueue_script('site-bundle', get_template_directory_uri() . '/dist/bundle.js', [], '1.0.0', true);

		// Encolar los estilos generados por Webpack
		wp_enqueue_style('site-styles', get_template_directory_uri() . '/dist/styles.css', [], '1.0.0', 'all');
	}

	/**
	 * This is where you can register custom post types.
	 */
	public function register_post_types()
	{
		CustomPosTypeLibro::register();
	}

	/**
	 * This is where you can register custom taxonomies.
	 */
	public function register_taxonomies()
	{
	}

	public function register_metaboxes()
	{
		HomeAdditionalBlockMetabox::init();
		HomeBlockMetabox::init();
		AboutPageMetabox::init();
	}

	/**
	 * This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context($context)
	{

		$context['menu']  = Timber::get_menu();
		$context['site']  = $this;
		$context['theme_url'] = get_template_directory_uri();
		$context['site_url'] = site_url();
		$context['custom_logo'] = get_custom_logo();
		$context['menu_links'] = $this->get_menu_links("menu");
		return $context;
	}

	public function theme_supports()
	{
		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */


		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support(
			'custom-logo', 
				array(
					'height'      => 100,
					'width'       => 400,
					'flex-height' => true,
					'flex-width'  => true,
		));

		add_theme_support('menus');
	}

	public function timber_get_posts()
	{
		$post = new Post();
		return $post;
	}

	/**
	 * Retrieves the links and their titles from the primary menu.
	 *
	 * This function fetches the menu items for the primary menu and returns an array
	 * of links with their corresponding titles.
	 *
	 * @return array An array of associative arrays, each containing 'title' and 'url' keys.
	 */
	public function get_menu_links($menu_name)
	{
	
		$menu = wp_get_nav_menu_items($menu_name);
		$menu_links = [];

		if ($menu) {
			foreach ($menu as $item) {
				$menu_links[] = [
					'title' => $item->title,
					'url' => $item->url,
				];
			}
		}

		return $menu_links;
	}


	public function get_excerpt($text, $length = 55)
	{
		if (strlen($text) <= $length) {
			return $text;
		}
		return substr($text, 0, $length) . '...';
	}


	/**
	 * This is where you can add your own functions to twig.
	 *
	 * @param \Twig\Environment $twig get extension.
	 */
	public function add_to_twig($twig)
	{
		/**
		 * Required when you want to use Twig’s template_from_string.
		 * @link https://twig.symfony.com/doc/3.x/functions/template_from_string.html
		 */
		// $twig->addExtension( new Twig\Extension\StringLoaderExtension() );

		$twig->addFilter(new \Twig\TwigFilter('post', [$this, 'timber_get_posts']));

		// Add dump() function to Twig, use only for debugging and delete in production
		$twig->addFilter(new \Twig\TwigFilter('dump', 'dump'));

		// Additional useful filters
		$twig->addFilter(new \Twig\TwigFilter('uppercase', 'strtoupper'));
		$twig->addFilter(new \Twig\TwigFilter('lowercase', 'strtolower'));
		$twig->addFilter(new \Twig\TwigFilter('json_encode', 'json_encode'));

		// Custom functions
		$twig->addFunction(new \Twig\TwigFunction('site_url', 'site_url'));
		$twig->addFunction(new \Twig\TwigFunction('wp_head', 'wp_head'));
		$twig->addFunction(new \Twig\TwigFunction('wp_footer', 'wp_footer'));

		// Agrega la función logo_url


		return $twig;
	}

	/**
	 * Updates Twig environment options.
	 *
	 * @link https://twig.symfony.com/doc/2.x/api.html#environment-options
	 *
	 * @param array $options An array of environment options.
	 *
	 * @return array
	 */
	function update_twig_environment_options($options)
	{
		//$options['autoescape'] = true;

		return $options;
	}

	private function initialize_general_options()
	{
		new GeneralOptions();
	}

}
