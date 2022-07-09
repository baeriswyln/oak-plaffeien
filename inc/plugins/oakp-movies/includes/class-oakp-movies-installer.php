<?php

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

class OAKP_Movies_Installer {

    public function register(){
        $this->register_movies();
    }

    private function register_movies() {
        $labels = array(
            'name' => __('Filmprogramm', 'textdomain'),
            'singular_name' => __('Film', 'textdomain'),
            'add_new' => __('Erstellen', 'textdomain'),
            'add_new_item' => __('Neuen Film erstellen', 'textdomain'),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'unser-programm'),
            'supports'=> array('title'),
        );

        register_post_type('oakp_movie', $args);
    }

}