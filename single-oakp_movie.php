<?php
$meta_value_tmdb_id = get_post_meta(get_the_ID(), '_tmdb_id', true);
$meta_value_date = get_post_meta(get_the_ID(), '_date', true);
$meta_value_poster = get_post_meta(get_the_ID(), '_poster', true);
$meta_value_backdrop = get_post_meta(get_the_ID(), '_backdrop', true);
$meta_value_synopsis = get_post_meta(get_the_ID(), '_synopsis', true);
$meta_value_description = get_post_meta(get_the_ID(), '_description', true);
$meta_value_age = get_post_meta(get_the_ID(), '_age', true);
$meta_value_duration = get_post_meta(get_the_ID(), '_duration', true);
$meta_value_genres = get_post_meta(get_the_ID(), '_genres', true);
$meta_value_director = get_post_meta(get_the_ID(), '_director', true);
$meta_value_trailer = get_post_meta(get_the_ID(), '_trailer', true);
$meta_value_tickets = get_post_meta(get_the_ID(), '_tickets', true);
$meta_value_tickets_embedded = get_post_meta(get_the_ID(), '_tickets_embedded', true);
$meta_value_year = get_post_meta(get_the_ID(), '_year', true);
$meta_value_language = get_post_meta(get_the_ID(), '_language', true);
$meta_value_countries = get_post_meta(get_the_ID(), '_countries', true);
$meta_value_actors = json_decode(get_post_meta(get_the_ID(), '_actors', true));
$meta_value_sponsor = get_post_meta(get_the_ID(), '_sponsor', true);

?>

<div class="oakp_movie header">
    <div class="backdrop" style="background-image: url('<?php echo $meta_value_backdrop ?>')"></div>
    <div class="movie-stripe"></div>
    <div class="title">
        <?php
        ini_set('intl.default_locale', 'de_DE');
        $calender = IntlCalendar::fromDateTime($meta_value_date);
        echo "<h2>" . IntlDateFormatter::formatObject($calender, "EEEEEE, d. MMMM") . "</h2>";
        ?>
        <h1><?php the_title_attribute() ?></h1>
        <div class="facts">
            <span class="certification"><?php echo $meta_value_age; ?> J</span>
            <span class="genre"><?php echo $meta_value_genres; ?></span>
            <span class="duration"><?php echo $meta_value_duration; ?>min</span>
            <span class="language"><?php echo $meta_value_language; ?></span>
        </div>
    </div>
</div>


<main id="qodef-page-content" class="qodef-grid qodef-layout--template">
    <div class="qodef-grid-inner clear">
        <article <?php post_class('qodef-movie-single-item qodef-e'); ?>>
            <div class="qodef-e-inner">
                <div class="wrapper bg-black">
                    <div class="row">
                        <div class="content-wrapper">
                            <div class="synopsis">
                                <?php echo $meta_value_synopsis; ?>
                            </div>
                            <div class="description">
                                <?php echo $meta_value_description; ?>
                            </div>
                            <div class="info">
                                <div class="mobile-only">
                                    <img src="<?php echo $meta_value_poster; ?>"/>
                                </div>
                                <div class="info-text">
                                    Produktion: <?php echo $meta_value_countries; ?> | <?php echo $meta_value_year ?>
                                    <br/>
                                    Regie: <?php echo $meta_value_director ?>
                                    <div class="mobile-only">
                                        <?php if (!empty($meta_value_tickets)) { ?>
                                            <a href="<?php echo $meta_value_tickets?>" class="eventfrog-btn  mobile-only" target="_blank">
                                                <span class="icon"></span>
                                                Tickets kaufen
                                            </a>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>


                            <div class="cast_title">Darsteller</div>
                            <div class="cast">
                                <?php foreach ($meta_value_actors as $actor) { ?>
                                    <div class="actor">
                                        <div class="face"
                                             style="background-image: url('<?php echo $actor->url ?>');"></div>
                                        <div>
                                            <div class="name"><?php echo $actor->name ?></div>
                                            <div class="as">als <?php echo $actor->as ?></div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <?php if (!empty($meta_value_sponsor)) { ?>
                                <div class="sponsor mobile-only">Präsentiert von:
                                    <a href="<?php echo get_post_meta($meta_value_sponsor, '_website', true); ?>"
                                       target="_blank">
                                        <img src="<?php echo get_the_post_thumbnail_url($meta_value_sponsor); ?>"/>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="poster-wrapper">
                            <div class="poster">
                                <img src="<?php echo $meta_value_poster; ?>"/>
                            </div>
                            <?php if (!empty($meta_value_tickets)) { ?>
                                <a href="<?php echo $meta_value_tickets?>" class="eventfrog-btn" target="_blank">
                                    <span class="icon"></span>
                                    Tickets kaufen
                                </a>
                            <?php } ?>

                            <?php if (!empty($meta_value_sponsor)) { ?>
                                <div class="sponsor">Präsentiert von:
                                    <a href="<?php echo get_post_meta($meta_value_sponsor, '_website', true); ?>"
                                       target="_blank">
                                        <img src="<?php echo get_the_post_thumbnail_url($meta_value_sponsor); ?>"/>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if(!empty($meta_value_tickets_embedded)) {?>
                    <div class="row">
                        <div class="tickets">
                            <?php echo $meta_value_tickets_embedded ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="wrapper">
                    <?php if (!empty($meta_value_trailer)) { ?>
                        <div class="curve-overlay"></div>
                        <div class="row">
                            <div class="trailer">
                                <iframe width="1200" height="600"
                                        src="https://www.youtube-nocookie.com/embed/<?php echo $meta_value_trailer; ?>"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
    </div>
    </article>
    </div>
</main>

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Event",
        "name": "<?php echo the_title_attribute(); ?>",
        "startDate": "<?php echo $meta_value_date; ?>T21:00",
        "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
        "eventStatus": "https://schema.org/EventScheduled",
        "location": {
            "@type": "Place",
            "name": "Open-Air Kino Plaffeien",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Schulhausweg",
                "addressLocality": "Plaffeien",
                "postalCode": "1716",
                "addressRegion": "FR",
                "addressCountry": "CH"
            }
        },
        "image": [
            "<?php echo $meta_value_poster; ?>"
        ],
        "description": "<?php echo $meta_value_synopsis; ?>",
        <?php if (!empty($meta_value_tickets)) { ?>
        "offers": {
            "@type": "Offer",
            "url": "<? echo $meta_value_tickets; ?>",
            "seller": {
                "@type": "Organization",
                "name": "Eventfrog",
                "url": "https://eventfrog.ch/de/home.html",
				"logo": "https://eventfrog.ch/img/relaunch/logos/eventfrog-desktop.svg"
            }
        },
        <?php } ?>
        "organizer": {
            "@type": "Organization",
            "name": "Open-Air Kino Plaffeien",
            "url": "https://openairkino-plaffeien.ch",
			"logo": "https://oak.baeriswyl.dev/wp-content/uploads/2021/06/Logo-Jakera-90x40-1.png"
        }
    }



</script>
