const api_media_url_original = 'https://image.tmdb.org/t/p/original';
const api_media_url_w185 = 'https://image.tmdb.org/t/p/w185';
const api_media_url_w92 = 'https://image.tmdb.org/t/p/w92';
const api_url = 'https://api.themoviedb.org/3';
const api_key = '71ea7d7f8fc5d15adfb1958b55436f1a';

const load_from_tmdb = function (with_title, movie_id) {
    movie_id = movie_id || jQuery('#oakp_movies_tmdb_id').val();
    console.log('Loading data for movie ' + movie_id);
    let url = api_url + '/movie/' + movie_id + '?language=de-DE&api_key=' + api_key;

    jQuery.getJSON(url, function (data) {
        jQuery('#oakp_movies_tmdb_id').val(movie_id);
        if (with_title) {
            jQuery('input#title').val(data.title);
        }

        jQuery('#oakp_movies_backdrop').val(api_media_url_original + data.backdrop_path);
        jQuery('#oakp_movies_poster').val(api_media_url_original + data.poster_path);
        jQuery('#oakp_movies_year').val((new Date(data.release_date).getFullYear()));
        jQuery('#oakp_movies_description').val(data.overview);
        jQuery('#oakp_movies_duration').val(data.runtime);


        if (data.genres) {
            let genres = '';
            let is_first = true;
            data.genres.forEach(function (item) {
                if (is_first) {
                    genres += item.name;
                    is_first = false;
                } else {
                    genres += ', ' + item.name;
                }
            });
            jQuery('#oakp_movies_genres').val(genres);
        }

        if (data.production_countries) {
            let countries = '';
            let is_first = true;
            data.production_countries.forEach(function (item) {
                if (is_first) {
                    countries += item.iso_3166_1;
                    is_first = false;
                } else {
                    countries += ', ' + item.iso_3166_1;
                }
            });
            jQuery('#oakp_movies_countries').val(countries)
        }

        load_credits_from_tmdb(movie_id);

    }).fail(function (error) {
        console.error('Unable to load data.');
    });
}

const load_credits_from_tmdb = function (movie_id) {
    let url = api_url + '/movie/' + movie_id + '/credits' + '?language=de-DE&api_key=' + api_key;

    jQuery.getJSON(url, function (data) {
        if (data.cast) {
            let actors = [];
            for (let i = 0; i < Math.min(4, data.cast.length); i++) {
                let item = data.cast[i];
                let actor = {
                    'name': item.name,
                    'as': item.character,
                    'url': api_media_url_w185 + item.profile_path
                };
                actors.push(actor);
            }
            jQuery('#oakp_movies_actors').val(JSON.stringify(actors)).change();
        }

        if (data.crew) {
            let directors = '';
            let is_first = true;
            data.crew.forEach(function (item) {
                if (item.job === 'Director') {
                    if (is_first) {
                        directors += item.name;
                        is_first = false;
                    } else {
                        directors += ', ' + item.name;
                    }
                }
            });
            jQuery('#oakp_movies_director').val(directors);
        }
    }).fail(function (error) {
        console.error('Unable to load credits.');
    });
}

const search_for_movie = function () {
    let url = api_url + '/search/movie?query=' + encodeURI(jQuery('input#title').val()) + '&api_key=' + api_key;

    jQuery.getJSON(url, function (data) {
        display_search_results(data)
    }).fail(function (error) {
        console.error('Found no movies');
    });
}

const display_search_results = function (data) {
    jQuery('#oakp_searchcomplete').css('display', 'block');

    let results = '';

    if (data.results.length > 0) {
        for (let i = 0; i < Math.min(data.results.length, 5); i++) {
            let item = data.results[i];
            results += '<div class="result" onclick="load_from_tmdb(true, ' + item.id + ')">';
            results += '<img src="' + api_media_url_w92 + item.poster_path + '" />';
            results += '<div class="content"><span class="title">' + item.original_title + '</span>'
            results += '<span class="overview">' + item.overview + '</span>'
            results += '</div></div>'
        }
    } else {
        results = '<div class="noresults">Keine Resultate gefunden</div>';
    }

    jQuery('#oakp_searchcomplete').html(results);
}

const hide_search_results = function () {
    setTimeout(function () {
        jQuery('#oakp_searchcomplete').css('display', 'none');
    }, 100);
}

const put_cast_in_table = function (cast) {
    let tbody = '    <tr class="no-items">\n' +
        '        <td class="colspanchange" colspan="3">Keine Schauspieler gespeichert</td>\n' +
        '    </tr>'

    if (cast) {
        try {
            console.log(cast);
            cast = JSON.parse(cast);

            tbody = '';

            cast.forEach(function (item) {
                tbody += '<tr>';
                tbody += '<td>' + item.name + '</td>';
                tbody += '<td>' + item.as + '</td>';
                tbody += '<td>' + item.url + '</td>';
                tbody += '</tr>';
            });
        } catch (e) {
            console.error('Unable to convert cast to JSON');
        }
    }
    jQuery('#oakp-movie-info #the-list').html(tbody);
}

jQuery(document).ready(function () {
    if(jQuery('#oakp-movie-info')) {
        put_cast_in_table(jQuery('#oakp_movies_actors').val());

        jQuery('#oakp_movies_actors').change(function () {
            put_cast_in_table(jQuery('#oakp_movies_actors').val());
        });

        jQuery('#titlewrap').append('<div id="oakp_searchcomplete"></div>');

        jQuery("#oakp_movies_tmdb_import").click(function (e) {
            e.preventDefault();
            load_from_tmdb(false);
        });

        jQuery('input#title').bind('input focus', function () {
            let $this = jQuery(this);
            let delay = 1000;

            clearTimeout($this.data('timer'));
            $this.data('timer', setTimeout(function () {
                $this.removeData('timer');
                search_for_movie();
            }, delay));
        });

        jQuery('input#title').blur(hide_search_results);

        jQuery(document).keyup(function (e) {
            if (e.keyCode == 27) {
                hide_search_results();
            }
        });
    }
});
