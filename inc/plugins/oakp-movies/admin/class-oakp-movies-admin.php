<?php

class OAKP_Movies_Admin
{

    protected $oakp_movies;
    protected $version;

    public function __construct($oakp_movies, $version)
    {
        $this->oakp_movies = $oakp_movies;
        $this->version = $version;
    }

    public function enqueue_styles()
    {
        wp_enqueue_style($this->oakp_movies, OAKP_MOVIES_URL . 'assets/css/admin.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script($this->oakp_movies, OAKP_MOVIES_URL . 'assets/js/admin.js', array('jquery'), $this->version, false);
    }

    /**
     * Stores the data from the metabox in the database.
     *
     * @param $post_id
     * @param $post
     * @return void
     */
    public function save_meta_boxes($post_id, $post)
    {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset ($_POST['oakp_movies_nonce']) && wp_verify_nonce($_POST['oakp_movies_nonce'], basename(__FILE__))) ? 'true' : 'false';

        if ($is_autosave || $is_revision || !$is_valid_nonce) return;
        if (get_post_type($post) !== 'oakp_movie') return;

        // Check inputs, sanitize and save if needed
        if (isset($_POST['_tmdb_id'])) update_post_meta($post_id, '_tmdb_id', sanitize_text_field($_POST['_tmdb_id']));
        if (isset($_POST['_date'])) update_post_meta($post_id, '_date', sanitize_text_field($_POST['_date']));
        if (isset($_POST['_poster'])) update_post_meta($post_id, '_poster', sanitize_text_field($_POST['_poster']));
        if (isset($_POST['_backdrop'])) update_post_meta($post_id, '_backdrop', sanitize_text_field($_POST['_backdrop']));
        if (isset($_POST['_synopsis'])) update_post_meta($post_id, '_synopsis', sanitize_text_field($_POST['_synopsis']));
        if (isset($_POST['_description'])) update_post_meta($post_id, '_description', sanitize_textarea_field($_POST['_description']));
        if (isset($_POST['_age'])) update_post_meta($post_id, '_age', sanitize_text_field($_POST['_age']));
        if (isset($_POST['_duration'])) update_post_meta($post_id, '_duration', sanitize_text_field($_POST['_duration']));
        if (isset($_POST['_genres'])) update_post_meta($post_id, '_genres', sanitize_text_field($_POST['_genres']));
        if (isset($_POST['_director'])) update_post_meta($post_id, '_director', sanitize_text_field($_POST['_director']));
        if (isset($_POST['_trailer'])) update_post_meta($post_id, '_trailer', sanitize_text_field($_POST['_trailer']));
        if (isset($_POST['_tickets'])) update_post_meta($post_id, '_tickets', sanitize_url($_POST['_tickets']));
        if (isset($_POST['_tickets_embedded'])) update_post_meta($post_id, '_tickets_embedded', $_POST['_tickets_embedded']);
        if (isset($_POST['_year'])) update_post_meta($post_id, '_year', sanitize_text_field($_POST['_year']));
        if (isset($_POST['_language'])) update_post_meta($post_id, '_language', sanitize_text_field($_POST['_language']));
        if (isset($_POST['_countries'])) update_post_meta($post_id, '_countries', sanitize_text_field($_POST['_countries']));
        if (isset($_POST['_actors'])) update_post_meta($post_id, '_actors', sanitize_text_field($_POST['_actors']));
        if (isset($_POST['_sponsor'])) update_post_meta($post_id, '_sponsor', sanitize_text_field($_POST['_sponsor']));
        update_post_meta($post_id, '_wp_page_template', 'page-full-width.php');
    }

    /**
     * Defines the content inside post list column "Vorstellungsdatum".
     * @return void
     */
    public function manage_custom_columns($column_key, $post_id)
    {
        switch ($column_key){
            case 'event_date':
                echo get_post_meta($post_id, '_date', true);
                break;
            default:
                break;
        }
    }

    /**
     * Adds a column "Vorstellungsdatum" to the post list.
     * @return array
     */
    public function manage_columns($columns)
    {
        return array_merge($columns, ['event_date' => __('Vorführungsdatum', 'oakp_movie')]);
    }

    public function manage_order_column( $columns ) {
        $columns['event_date'] = 'event_date';

        return $columns;
    }

    /**
     * Adds the meta box to the admin page allowing for movie information to be entered.
     *
     * @return void
     */
    public function add_meta_boxes()
    {
        add_meta_box('oakp-movie-info', __('Filmdaten', 'oakp-movie'), array($this, 'movies_info_metabox'), 'oakp_movie', 'normal', 'high');
    }

    /**
     * Includes the movies metabox layout.
     *
     * @param $post
     * @return void
     */
    public function movies_info_metabox($post)
    {
        include_once 'meta-boxes/movie-info.php';
    }

}