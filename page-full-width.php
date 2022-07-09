<?php
/*
Template Name: Qode Full Width Template
*/

get_header();

// Include content template
if(get_post_type() === 'oakp_movie'){
    include_once 'single-oakp_movie.php';
} else {

// Include content template
    pelicula_template_part( 'content', 'templates/content' );
}

get_footer();