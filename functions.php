<?php

/**
 * Function that return config variables for page footer
 *
 * @return array
 */
function pelicula_get_page_footer_sidebars_config()
{

    // Config variables
    $config = apply_filters('pelicula_filter_page_footer_sidebars_config', array(
        'title_class' => 'qodef-widget-title',
        'footer_top_sidebars_number' => 1,
        'footer_top_title_tag' => 'h4',
        'footer_bottom_sidebars_number' => 2,
        'footer_bottom_title_tag' => 'h5'
    ));

    return $config;
}

if (!function_exists('pelicula_child_theme_enqueue_scripts')) {
    /**
     * Function that enqueue theme's child style
     */
    function pelicula_child_theme_enqueue_scripts()
    {
        $main_style = 'pelicula-main';

        wp_enqueue_style('pelicula-child-style', get_stylesheet_directory_uri() . '/style.css', array($main_style));
    }

    add_action('wp_enqueue_scripts', 'pelicula_child_theme_enqueue_scripts');
}


if (!function_exists('add_file_types_to_uploads')) {
    function add_file_types_to_uploads($file_types): array
    {
        $new_filetypes = array();
        $new_filetypes['svg'] = 'image/svg+xml';
        $file_types = array_merge($file_types, $new_filetypes);
        return $file_types;
    }

    add_filter('upload_mimes', 'add_file_types_to_uploads');
}


/**
 * Loading the Movies plugin
 */
require_once __DIR__ . '/inc/plugins/oakp-movies/oakp-movies.php';