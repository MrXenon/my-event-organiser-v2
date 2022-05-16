<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
// Maak de shortcode aan | Shortcode naam, shortcode functie
add_shortcode('my_event_organiser_main_view','load_main_view');

// Shortcode functie, wat moet de functie ophalen?
function load_main_view( $atts, $content = NULL){

        include MY_EVENT_ORGANISER_PLUGIN_INCLUDES_VIEWS_DIR.
            '/my_event_organiser_main_view.php';
}

