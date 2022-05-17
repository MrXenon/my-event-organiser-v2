<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */

// plug-in definities
//Plug-in versie/
define ( 'MY_EVENT_ORGANISER_VERSION', '1.0.2' );
// Wordpress versie
define ( 'MY_EVENT_ORGANISER_REQUIRED_WP_VERSION', '5.9.3' );
// plug-in basename
define ( 'MY_EVENT_ORGANISER_PLUGIN_BASENAME', plugin_basename( MY_EVENT_ORGANISER_PLUGIN ) );
/// plug-in name
define ( 'MY_EVENT_ORGANISER_PLUGIN_NAME', trim( dirname ( MY_EVENT_ORGANISER_PLUGIN_BASENAME ), '/' ) );
// plug-in directory
define ( 'MY_EVENT_ORGANISER_PLUGIN_DIR', untrailingslashit( dirname ( MY_EVENT_ORGANISER_PLUGIN ) ) );

// plug-in mappen structuur
define ( 'MY_EVENT_ORGANISER_PLUGIN_INCLUDES_DIR', MY_EVENT_ORGANISER_PLUGIN_DIR . '/includes' );

define ( 'MY_EVENT_ORGANISER_PLUGIN_CSS_DIR', MY_EVENT_ORGANISER_PLUGIN_DIR . '/css' );

define ( 'MY_EVENT_ORGANISER_PLUGIN_ICONS_DIR', MY_EVENT_ORGANISER_PLUGIN_DIR . '/icons' );

define ( 'MY_EVENT_ORGANISER_PLUGIN_INCLUDES_VIEWS_DIR', MY_EVENT_ORGANISER_PLUGIN_INCLUDES_DIR	. '/views'	);

define ( 'MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR', MY_EVENT_ORGANISER_PLUGIN_INCLUDES_DIR . '/model' );

define ( 'MY_EVENT_ORGANISER_PLUGIN_MODEL_SRC_DIR', MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR . '/srcModel' );

define ( 'MY_EVENT_ORGANISER_PLUGIN_CALENDAR_DIR', MY_EVENT_ORGANISER_PLUGIN_INCLUDES_DIR . '/calendar' );

define ( 'MY_EVENT_ORGANISER_PLUGIN_ADMIN_DIR', MY_EVENT_ORGANISER_PLUGIN_DIR . '/admin' );

define ( 'MY_EVENT_ORGANISER_PLUGIN_ADMIN_VIEWS_DIR', MY_EVENT_ORGANISER_PLUGIN_ADMIN_DIR . '/views' );

?>