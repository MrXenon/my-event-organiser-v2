<?php

defined( 'ABSPATH' ) OR exit;

/**
 * Plugin Name: My event organisator plugin
 * Plugin URI: <>
 * Description: My Event Organiser, de tutorial plug-in die ontwikkeld is om studenten te leren hoe zij het beste een plug-in kunnen ontwikkelen, met daarin de core features die bij het plug-in ontwikkelen langs komen.
 * Version: 1.0.1
 * Author: Kevin Schuit
 * Author URI: https://kevinschuit.com
 * Text Domain: my-event-organiser
 * Domain Path: /lang/
 */
    // Definieer de plug-in file naam.
     define ( 'MY_EVENT_ORGANISER_PLUGIN', __FILE__ );
    // laad de definitie file.
    require_once plugin_dir_path ( __FILE__ ) . 'includes/defs.php';
    // Laad de insertie klasse.
     require_once (MY_EVENT_ORGANISER_PLUGIN_MODEL_SRC_DIR.'/classInsertion.class.php');
    // Laad de updater klasse.
    require_once ( 'MEOPluginUpdater.php' );

    // Hooks
    register_activation_hook( __FILE__, array( 'MyEventOrganiser', 'on_activation' ) );
    register_deactivation_hook( __FILE__, array( 'MyEventOrganiser', 'on_deactivation' ) );
 
 class MyEventOrganiser
 {
     // Tijdens de installatie, initialiseer de admin en benodigdheden.
     public function __construct()
     {

         do_action('my_event_organiser_pre_init');

         add_action('init', array($this, 'init'), 1);
     }

     // Voer deze functies uit tijdens activatie/
     public static function on_activation()
     {
         if ( ! current_user_can( 'activate_plugins' ) )
             return;
         $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
         check_admin_referer( "activate-plugin_{$plugin}" );

         MyEventOrganiser::requireUserRoleEditor();
         MyEventOrganiser::add_plugin_caps();
         MyEventOrganiser::createDb();
         MyEventOrganiser::create_page();
         Insertion::buildSourceTables();
     }
     // Voer deze functies uit tijdens deactivatie.
     public static function on_deactivation()
     {
         if ( ! current_user_can( 'activate_plugins' ) )
             return;
         $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
         check_admin_referer( "deactivate-plugin_{$plugin}" );

         MyEventOrganiser::remove_plugin_caps();
         MyEventOrganiser::delete_plugin_database_tables();
         MyEventOrganiser::delete_plugin_page();
     }

     // Check of de user role editor al actief is en geïnstalleerd, zo niet, toon ons de download link.
    public function requireUserRoleEditor(){

        if ( ! is_plugin_active( 'user-role-editor/user-role-editor.php' ) and current_user_can( 'activate_plugins' ) ) {
            $plugin_name = 'user-role-editor';
            $install_link = 'The following plug-in is required in order to run this plug-in <a href="' . esc_url( network_admin_url('plugin-install.php?tab=plugin-information&plugin=' . $plugin_name . '&TB_iframe=true&width=600&height=550' ) ) . '" class="thickbox" title="More info about ' . $plugin_name . '">Install ' . $plugin_name . '</a>';
            wp_die($install_link);
       }
    }

    // Initialisatie functie.
     public function init()
     {
         // geef positiee van de eigen meta aan op de plug-in.
        add_filter( 'plugin_row_meta', [$this, 'custom_plugin_row_meta'], 10, 2 );

        // initialiseer d my event organiser
         do_action('my_event_organiser_init');

         if (is_admin()) {

            // Voeg de admin controller file toe.
             $this->requireAdmin();

             // Maak de admin controller aan.
             $this->createAdmin();
             // roep de updater aan.
             new MEOPluginUpdater( __FILE__, 'MrXenon', "my-event-organiser-kevin" );
         } else {

            // Voeg scripts toe aan het front-end.
             wp_enqueue_script('calendar-script', '/wp-content/plugins/my-event-organiser-v2/includes' . '/calendar/calendar.js');
             wp_enqueue_style('frontStyle','/wp-content/plugins/my-event-organiser-v2/css' .'/style.css');

             wp_enqueue_script('bootstrap1', plugin_dir_url(__FILE__).'/bootstrap-5.1.3-dist/js/bootstrap.bundle.js');
             wp_enqueue_script('bootstrap2', plugin_dir_url(__FILE__).'/bootstrap-5.1.3-dist/js/bootstrap.esm.js');
             wp_enqueue_script('bootstrap3', plugin_dir_url(__FILE__).'/bootstrap-5.1.3-dist/js/bootstrap.js');
             wp_enqueue_script('bootstrap4', plugin_dir_url(__FILE__).'/bootstrap-5.1.3-dist/jquery/jquery.slim.min.js');
     
             wp_enqueue_style('bootstrap1', plugin_dir_url(__FILE__).'/bootstrap-5.1.3-dist/css/bootstrap.css');
             wp_enqueue_style('bootstrap2', plugin_dir_url(__FILE__).'/bootstrap-5.1.3-dist/css/bootstrap-utilities.css');
             wp_enqueue_style('bootstrap3', plugin_dir_url(__FILE__).'/bootstrap-5.1.3-dist/css/bootstrap-grid.css');
         }

         $this->loadViews();
     }

     // Maak eigen meta aan en voeg deze toe aan de plug-in.
     public function custom_plugin_row_meta( $links, $file ) 
    {
        // check of de plug-in file naam overeen komt met die van de huidige plug-in.
        if ( strpos( $file, 'my-event-organiser.php' ) !== false ) {
	    $new_links = array(
            '<a href="http://gzwv.kevinschuit.com" target="_blank">Bekijk tutorial</a>',
            '<a href="mailto:info@kevinschuit.com" target="_blank">Support</a>',
               '<a href="'.admin_url().'admin.php?page=meo_admin_dashboard">Dashboard</a>'
			);
		
		$links = array_merge( $links, $new_links );
	}
	
	return $links;
    }

    // definieer de admin controller.
     public function requireAdmin()
     {

         require_once MY_EVENT_ORGANISER_PLUGIN_ADMIN_DIR . '/MyEventOrganiser_AdminController.php';
     }

     // prepareer de admin controller en bouw de pagina links.
     public function createAdmin()
     {
         MyEventOrganiser_AdminController::prepare();
     }
     // Laad de shortcode pagina
     public function loadViews()
     {
         include MY_EVENT_ORGANISER_PLUGIN_INCLUDES_VIEWS_DIR . '/view_shortcodes.php';
     }

     // definieer de plugin rollen in de user role editor.
     public static function get_plugin_roles_and_caps(){


         return array (

             array('administrator',
                 'Admin',
                 array( 'ivs_meo_event_read',
                     'ivs_meo_event_create',
                     'ivs_meo_event_update',
                     'ivs_meo_event_delete') ),

             array('ivs_manager',
                 'IVS_Manager',
                 array( 'ivs_meo_event_read',
                     'ivs_meo_event_create',
                     'ivs_meo_event_update',
                     'ivs_meo_event_delete') ),

             array('project_lid',
                 'Project lid',
                 array( 'ivs_meo_event_read') )
         );

     }

     // Voeg de plugin capabillities toe van de user role editor
     public static function add_plugin_caps() {


         require_once plugin_dir_path( __FILE__ ) .
             'includes/roles_and_caps_defs.php';

         $role_array = MyEventOrganiser::get_plugin_roles_and_caps();

         foreach ($role_array as $key => $role_name) {

             if( !( $GLOBALS['wp_roles']->is_role(
                 $role_name[MEO_EVENT_ROLE_NAME] )) ){

                 $role = add_role($role_name[MEO_EVENT_ROLE_NAME],
                     $role_name[MEO_EVENT_ROLE_ALIAS], array('read' => true, 'level_0' => true));
             }
         }

         foreach ($role_array as $key => $role_name) {

             foreach ($role_name[MEO_EVENT_ROLE_CAP_ARRAY] as $cap_key =>
                      $cap_name) {

                 $role = get_role( $role_name[MEO_EVENT_ROLE_NAME] );

                 $role->add_cap( $cap_name );
            }
         }
     }

     // verwijder de plugin capabllities van user role editor
     public static function remove_plugin_caps(){

         require_once plugin_dir_path( __FILE__ ) .
             'includes/roles_and_caps_defs.php';

         $role_array = MyEventOrganiser::get_plugin_roles_and_caps();

         foreach ($role_array as $key => $role_name) {

             foreach ($role_name[MEO_EVENT_ROLE_CAP_ARRAY] as $cap_key => $cap_name) {

                             $role = get_role( $role_name[MEO_EVENT_ROLE_NAME] );

                                 $role->remove_cap( $cap_name );
             }
         }
     }

     // maak de database aan
     public static function createDb()
     {
         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
         global $wpdb;

         $charset_collate = $wpdb->get_charset_collate();
        // definieer de tabellen
         $event         =    $wpdb->prefix . "meo_event";
         $category      =    $wpdb->prefix . "meo_event_category";
         $types         =    $wpdb->prefix . "meo_event_type";
         $signup        =    $wpdb->prefix . "meo_event_signup";

         $sql = "CREATE TABLE IF NOT EXISTS $event (
            id_event BIGINT(10) NOT NULL AUTO_INCREMENT,
            event_title VARCHAR(64) NOT NULL,
            fk_event_category BIGINT(11) NOT NULL,
            fk_event_type bigint(10) NOT NULL,
            event_info varchar(1024) NOT NULL,
            event_date date NOT NULL,
            event_due_date date NOT NULL,
            event_end_date date DEFAULT NULL,
            PRIMARY KEY  (id_event))
            ENGINE = InnoDB $charset_collate";
         dbDelta($sql);

         $sql = "CREATE TABLE IF NOT EXISTS $category (
            id_event_category BIGINT(10) NOT NULL AUTO_INCREMENT,
            name varchar(32) NOT NULL,
            description varchar(1024) NOT NULL,
            PRIMARY KEY  (id_event_category))
            ENGINE = InnoDB $charset_collate";
         dbDelta($sql);

         $sql = "CREATE TABLE IF NOT EXISTS $types (
            id_event_type BIGINT(10) NOT NULL AUTO_INCREMENT,
            name varchar(32) NOT NULL,
            description varchar(1024) NOT NULL,
            PRIMARY KEY  (id_event_type))
            ENGINE = InnoDB $charset_collate";
         dbDelta($sql);

         $sql = "CREATE TABLE IF NOT EXISTS $signup (
            id INT(11) NOT NULL AUTO_INCREMENT,
            event_title INT(11) NOT NULL,
            event_user INT(11) NOT NULL,
            PRIMARY KEY  (id))
            ENGINE = InnoDB $charset_collate";
         dbDelta($sql);
     }

     // Verwijder de plugin tabellen
     public static function delete_plugin_database_tables()
    {
        global $wpdb;
        // tabel array
        $tableArray = [
            $wpdb->prefix . "meo_event",
            $wpdb->prefix . "meo_event_category",
            $wpdb->prefix . "meo_event_type",
            $wpdb->prefix . "meo_event_signup"
        ];
        // Drop de tabellen voor elke naam in de array
        foreach ($tableArray as $tablename) {
            $wpdb->query("DROP TABLE IF EXISTS $tablename");
        }
    }
    // Maak de plugin front-end pagina aan
    public static function create_page()
    {
        // check of de gebruiker plugins kan activeren.
        if (!current_user_can('activate_plugins')) return;

        global $wpdb;
        // als de pagina nog niet bestaat, run de query en maak deze aan.
        if (null === $wpdb->get_row("SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'my-event-organiser'", 'ARRAY_A')) {

            $current_user = wp_get_current_user();
            $page = array(
                'post_title' => __('My event organiser'),
                'post_content' => '[my_event_organiser_main_view]',
                'post_status' => 'publish',
                'post_author' => $current_user->ID,
                'post_type' => 'page',
            );

            wp_insert_post($page);
        }
    }
    // Verwijder de plug-in pagina 'My Event Organiser'
    public static function delete_plugin_page()
    {
        global $wpdb;
        // pagina array
        $postArray = [
         "My event organiser"
        ];
        // Verwijder elke pagina in de array
        foreach ($postArray as $postTitle) {
            $wpdb->query("DELETE FROM `".$wpdb->prefix. "posts` WHERE post_title = '$postTitle'");
        }
    }

 }
// Roep de plug-in aan
 $event_organiser = new MyEventOrganiser();
 ?>