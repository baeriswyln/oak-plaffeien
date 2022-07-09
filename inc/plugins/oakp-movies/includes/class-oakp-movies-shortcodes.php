<?php

class OAKP_Movies_Shortcodes
{

    public function register_shortcodes()
    {
        add_shortcode('movies_menu', array(__CLASS__, 'movies_menu_shortcode'));
        add_shortcode('movies_program', array(__CLASS__, 'movies_program_shortcode'));
        add_shortcode('movies_footer', array(__CLASS__, 'movies_footer_shortcode'));
        add_shortcode('movies_presenter', array(__CLASS__, 'movies_presenter_shortcode'));
    }

    private static function get_movies(): array
    {
        $args = array(
            'post_type' => array('oakp_movie'),
            'post_status' => 'publish',
            'numberposts' => -1,
            'pagination' => false,
            'no_found_rows' => true,
            'meta_key' => '_date',
            'order' => 'ASC',
            'orderby' => 'meta_value',
        );

        return get_posts($args);
    }

    public static function movies_menu_shortcode($atts = array())
    {
        ob_start();

        $movie_posts = self::get_movies();

        echo '<nav class="oakp_movies_menu_shortcode"><ul>';
        foreach ($movie_posts as $movie_post) {
            echo '<li><a href="' . get_permalink($movie_post->ID) . '">' . get_the_title($movie_post) . '</a></li>';
        }
        echo '</ul></nav>';

        return ob_get_clean();
    }

    public static function movies_program_shortcode($atts = array())
    {
        ob_start();

        $movie_posts = self::get_movies();

        echo '<div class="oakp_movies_program_shortcode">';
        foreach ($movie_posts as $movie) {
            $age = get_post_meta($movie->ID, '_age', true);
            $duration = get_post_meta($movie->ID, '_duration', true);
            $genres = get_post_meta($movie->ID, '_genres', true);
            $language = get_post_meta($movie->ID, '_language', true);
            $poster = get_post_meta($movie->ID, '_poster', true);
            $synopsis = get_post_meta($movie->ID, '_synopsis', true);

            ini_set('intl.default_locale', 'de_DE');
            $meta_value_date = get_post_meta($movie->ID, '_date', true);
            $calender = IntlCalendar::fromDateTime($meta_value_date);
            $date = IntlDateFormatter::formatObject($calender, "EEEEEE, d. MMMM");
            ?>
            <div class="card_movie">
                <a href="<?php echo get_permalink($movie->ID); ?>" class="wrapper">
                    <img class="poster mobile-hidden"
                         src="<?php echo $poster; ?>"/>
                    <div class="details">
                        <div class="backdrop"
                             style="background-image: url('<?php echo get_post_meta($movie->ID, '_backdrop', true); ?>');"></div>
                        <div class="wrapper">
                            <div class="title"><?php echo get_the_title($movie->ID); ?></div>
                            <div class="date"><?php echo $date; ?></div>
                            <div class="facts">
                                <span class="certification"><?php echo $age; ?> J</span>
                                <span class="genre mobile-hidden"><?php echo $genres; ?></span>
                                <span class="duration"><?php echo $duration; ?>min</span>
                                <span class="language"><?php echo $language; ?></span>
                            </div>
                            <div class="synopsis"><?php echo $synopsis; ?></div>
                        </div>
                    </div>
                </a>
            </div>

            <?php
        }
        echo '</div>';

        return ob_get_clean();
    }

    public static function movies_footer_shortcode($atts = array())
    {
        ob_start();

        $movie_posts = self::get_movies();

        echo '<div class="oakp_movies_footer_shortcode">';
        foreach ($movie_posts as $movie) {
            $age = get_post_meta($movie->ID, '_age', true);
            $duration = get_post_meta($movie->ID, '_duration', true);
            $actors_obj = json_decode(get_post_meta($movie->ID, '_actors', true));

            ini_set('intl.default_locale', 'de_DE');
            $meta_value_date = get_post_meta($movie->ID, '_date', true);
            $calender = IntlCalendar::fromDateTime($meta_value_date);
            $date = IntlDateFormatter::formatObject($calender, "d. MMMM");

            $is_first = true;
            $actors = '';

            foreach ($actors_obj as $actor) {
                if ($is_first) {
                    $actors .= $actor->name;
                    $is_first = false;
                } else {
                    $actors .= ', ' . $actor->name;
                }
            }
            ?>
            <a href="<?php echo get_permalink($movie->ID); ?>">
                <div class="movie">
                    <div class="left">
                        <span class="date"><?php echo $date; ?></span>
                        <span class="duration-age"><? echo $duration . 'min / ' . $age . ' J'; ?></span>
                    </div>
                    <div class="right">
                        <span class="title"><?php echo get_the_title($movie->ID); ?></span>
                        <span class="actors"><?php echo $actors ?></span>
                    </div>
                </div>
            </a>
            <?php
        }
        echo '</div>';

        return ob_get_clean();
    }

    public static function movies_presenter_shortcode($atts = array())
    {
        $atts = shortcode_atts(array(
            'n_movies' => 3
        ), $atts, 'movies_presenter');

        ob_start();

        $movies = self::get_movies();

        $numbers = range(0, sizeof($movies) - 1);
        shuffle($numbers);

        echo '<div class="oakp_movies_presenter_shortcode">';

        for ($i = 0; $i < $atts['n_movies']; $i++) {
            $movie = $movies[$numbers[$i]];

            $title = get_the_title($movie->ID);
            $poster = get_post_meta($movie->ID, '_poster', true);

            ?>
            <a href="<?php echo get_permalink($movie->ID); ?>">
                <div class="movie">
                    <div class="poster">
                        <img src="<?php echo $poster; ?>"/>
                    </div>
                    <div class="title"><?php echo $title; ?></div>
                </div>
            </a>


            <?php
        }

        echo '</div>';

        return ob_get_clean();
    }

}

?>