<?php
// Display code/markup goes here. Don't forget to include nonces!
// Noncename needed to verify where the data originated
echo '<input type="hidden" name="wp_sponsors_nonce" id="oakp_movies_nonce" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';

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
$meta_value_actors = htmlspecialchars(get_post_meta(get_the_ID(), '_actors', true));
$meta_value_sponsor = get_post_meta(get_the_ID(), '_sponsor', true);

?>


<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_tmdb_id" class="post-attributes-label">TMDB ID</label>
    <button id="oakp_movies_tmdb_import" class="button button-primary button-small ">Daten von TMDB importieren</button>
    <input id="oakp_movies_tmdb_id" type="number" name="_tmdb_id" class="widefat"
           value="<?php echo $meta_value_tmdb_id; ?>"/>
</p>


<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_date" class="post-attributes-label">Vorführungsdatum</label>
    <input id="oakp_movies_date" type="date" name="_date" class="widefat" value="<?php echo $meta_value_date; ?>"/>
</p>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_poster" class="post-attributes-label">Link zu Filmposter</label>
    <input id="oakp_movies_poster" type="url" name="_poster" class="widefat" value="<?php echo $meta_value_poster; ?>"/>
</p>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_backdrop" class="post-attributes-label">Link zu Hintergrundbild</label>
    <input id="oakp_movies_backdrop" type="url" name="_backdrop" class="widefat" value="<?php echo $meta_value_backdrop; ?>"/>
</p>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_synopsis" class="post-attributes-label">Kurzbeschreibung</label>
    <input id="oakp_movies_synopsis" type="text" name="_synopsis" class="widefat" value="<?php echo $meta_value_synopsis; ?>"/>
</p>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_description" class="post-attributes-label">Beschreibung</label>
    <textarea id="oakp_movies_description" type="text" name="_description" class="widefat" rows="5"><?php echo $meta_value_description; ?></textarea>
</p>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_age" class="post-attributes-label">Altersfreigabe</label>
    <input id="oakp_movies_age" type="text" name="_age" class="widefat" value="<?php echo $meta_value_age; ?>"/>
</p>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_duration" class="post-attributes-label">Dauer (min)</label>
    <input id="oakp_movies_duration" type="number" name="_duration" class="widefat" value="<?php echo $meta_value_duration; ?>"/>
</p>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_genres" class="post-attributes-label">Genres</label>
    <input id="oakp_movies_genres" type="text" name="_genres" class="widefat" value="<?php echo $meta_value_genres; ?>"/>
</p>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_director" class="post-attributes-label">Regie</label>
    <input id="oakp_movies_director" type="text" name="_director" class="widefat" value="<?php echo $meta_value_director; ?>"/>
</p>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_actors" class="post-attributes-label">Schauspieler</label>
    <input id="oakp_movies_actors" type="text" name="_actors" class="widefat" value="<?php echo $meta_value_actors; ?>"/>
</p>

<!--
<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_actors" class="post-attributes-label">Cast</label>
    <input type="text" name="_actor_name" class="widefat"/>
    <input type="text" name="_actor_movie_name" class="widefat"/>
    <input type="text" name="_actor_picture" class="widefat"/>
    <button id="oakp_movies_add_actor" class="button button-primary">Schauspieler hinzufügen</button>
</p>-->

<table class="wp-list-table widefat fixed striped table-view-list posts">
    <thead>
    <tr>
        <th class="manage-column column-title column-primary">Name</th>
        <th class="manage-column column-title column-primary">Charakter</th>
        <th class="manage-column column-title column-primary">Link</th>
    </tr>
    </thead>
    <tbody id="the-list">
    <tr class="no-items">
        <td class="colspanchange" colspan="3">Keine Schauspieler gespeichert</td>
    </tr>
    </tbody>
</table>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_trailer" class="post-attributes-label">Youtube Trailer Vide ID (nicht URL)</label>
    <input id="oakp_movies_trailer" type="text" name="_trailer" class="widefat" value="<?php echo $meta_value_trailer; ?>"/>
</p>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_tickets" class="post-attributes-label">Eventfrog link</label>
    <input id="oakp_movies_tickets" type="url" name="_tickets" class="widefat" value="<?php echo $meta_value_tickets; ?>"/>
</p>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_tickets_embedded" class="post-attributes-label">Eventfrog embedded</label>
    <textarea id="oakp_movies_tickets_embedded" type="url" name="_tickets_embedded" class="widefat"><?php echo $meta_value_tickets_embedded; ?></textarea>
</p>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_year" class="post-attributes-label">Erschreinungsjahr</label>
    <input id="oakp_movies_year" type=number name="_year" class="widefat" value="<?php echo $meta_value_year; ?>"/>
</p>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_countries" class="post-attributes-label">Produktionsländer</label>
    <input id="oakp_movies_countries" type="text" name="_countries" class="widefat" value="<?php echo $meta_value_countries; ?>"/>
</p>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_language" class="post-attributes-label">Vorführungssprache</label>
    <input id="oakp_movies_language" type="text" name="_language" class="widefat" value="<?php echo $meta_value_language; ?>"/>
</p>

<p class="post-attributes-label-wrapper">
    <label for="oakp_movies_sponsor" class="post-attributes-label">Filmsponsor</label>
    <input id="oakp_movies_sponsor" type="text" name="_sponsor" class="widefat" value="<?php echo $meta_value_sponsor; ?>"/>
</p>