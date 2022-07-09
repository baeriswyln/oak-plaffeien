<?php

class OAKP_Movies
{

    protected $loader;
    protected $oakp_movies;
    protected $version;

    public function __construct()
    {
        $this->oakp_movies = 'oakp-movies';
        $this->version = '0.0';

        $this->define_constants();
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_general_hooks();
    }

    private function define_constants(){
        if(!defined('OAKP_MOVIES_URL')){
            define('OAKP_MOVIES_URL', get_theme_file_uri() . '/inc/plugins/oakp-movies/');
        }
    }

    private function load_dependencies()
    {
        /**
         * Class that is responsible for adding all actions and filters.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-oakp-movies-loader.php';

        /**
         * Classes responsible for defining functionality of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-oakp-movies-installer.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-oakp-movies-shortcodes.php';


        /**
         * Backend and frontend functions and initialization.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-oakp-movies-admin.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-oakp-movies-public.php';

        $this->loader = new OAKP_Movies_Loader();
    }

    private function define_admin_hooks()
    {
        if (!is_admin()) {
            return;
        }

        $plugin_admin = new OAKP_Movies_Admin($this->get_oakp_movies(), $this->get_version());

        $this->loader->add_action( 'save_post', $plugin_admin,'save_meta_boxes', 10, 2 );
        $this->loader->add_action('add_meta_boxes', $plugin_admin, 'add_meta_boxes');
        $this->loader->add_filter('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_filter('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

        $this->loader->add_filter('manage_oakp_movie_posts_columns', $plugin_admin, 'manage_columns');
        $this->loader->add_action('manage_oakp_movie_posts_custom_column', $plugin_admin, 'manage_custom_columns', 10, 2);
        $this->loader->add_filter( 'manage_edit-oakp_movie_sortable_columns', $plugin_admin,'manage_order_column' );
    }

    private function define_public_hooks(){
        $plugin_public = new OAKP_Movies_Public($this->get_oakp_movies(), $this->get_version());

        $this->loader->add_filter('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_filter('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
    }

    private function define_general_hooks() {
        $installer = new OAKP_Movies_Installer();
        $shortcodes = new OAKP_Movies_Shortcodes();

        $this->loader->add_action('init', $installer, 'register');
        $this->loader->add_action( 'init', $shortcodes, 'register_shortcodes', 0 );
    }

    public function run()
    {
        $this->loader->run();
    }

    /**
     * @return mixed
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * @return string
     */
    public function get_oakp_movies(): string
    {
        return $this->oakp_movies;
    }

    /**
     * @return string
     */
    public function get_version(): string
    {
        return $this->version;
    }
}