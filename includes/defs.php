<?php

/**
 * Defenitions needed in the plugin
 * 
 * @author
 * @version 0.1
 * 
 * Version history
 * 0.1      Initial version
 */
// De versie moet gleijk zij met het versie nummer in de my-event-organiser.php header
define ( 'MY_EVENT_ORGANISER_VERSION', '0.0.1' );

// Minimum required Wordpress version for this plugin
define ( 'MY_EVENT_ORGANISER_REQUIRED_WP_VERSION', '5.9.3' );

define ( 'MY_EVENT_ORGANISER_PLUGIN_BASENAME', plugin_basename( MY_EVENT_ORGANISER_PLUGIN ) );

define ( 'MY_EVENT_ORGANISER_PLUGIN_NAME', trim( dirname ( MY_EVENT_ORGANISER_PLUGIN_BASENAME ), '/' ) );

// Folder Structure
define ( 'MY_EVENT_ORGANISER_PLUGIN_DIR', untrailingslashit( dirname ( MY_EVENT_ORGANISER_PLUGIN ) ) );

define ( 'MY_EVENT_ORGANISER_PLUGIN_INCLUDES_DIR', MY_EVENT_ORGANISER_PLUGIN_DIR . '/includes' );

define ( 'MY_EVENT_ORGANISER_PLUGIN_INCLUDES_VIEWS_DIR', MY_EVENT_ORGANISER_PLUGIN_INCLUDES_DIR	. '/views'	);

define ( 'MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR', MY_EVENT_ORGANISER_PLUGIN_INCLUDES_DIR . '/model' );

define ( 'MY_EVENT_ORGANISER_PLUGIN_MODEL_SRC_DIR', MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR . '/srcModel' );

define ( 'MY_EVENT_ORGANISER_PLUGIN_CALENDAR_DIR', MY_EVENT_ORGANISER_PLUGIN_INCLUDES_DIR . '/calendar' );

define ( 'MY_EVENT_ORGANISER_PLUGIN_ADMIN_DIR', MY_EVENT_ORGANISER_PLUGIN_DIR . '/admin' );

define ( 'MY_EVENT_ORGANISER_PLUGIN_ADMIN_VIEWS_DIR', MY_EVENT_ORGANISER_PLUGIN_ADMIN_DIR . '/views' );

?>