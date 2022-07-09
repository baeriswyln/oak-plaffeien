<?php

class OAKP_Movies_Public {

    protected $oakp_movies;
    protected $version;

    public function __construct($oakp_movies, $version)
    {
        $this->oakp_movies = $oakp_movies;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style( $this->oakp_movies, OAKP_MOVIES_URL . 'assets/css/public.css', array(), $this->version, 'all' );
    }
    public function enqueue_scripts(){
        wp_enqueue_script( $this->oakp_movies, OAKP_MOVIES_URL . 'assets/js/public.js', array('jquery'), $this->version, false);
    }

    public function include_templates($template){
        $post_types = array('post');

        if(is_singular($post_types)){
            $template = plugin_dir_path(dirname(__FILE__)) . 'single-oakp_movie.php';
        }
        return $template;
    }

}
