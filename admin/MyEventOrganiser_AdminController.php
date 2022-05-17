<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
 class MyEventOrganiser_AdminController {

    // prepareer het admin menu
    static function prepare() {
        // zijn wij een administrator?
        if ( is_admin() ) :

            add_action( 'admin_menu', array( 'MyEventOrganiser_AdminController', 'addMeoMenus' ) );

        endif;
    }
                // Maak het menu aan en voeg de bootstrap scripts toe.
                static function addMeoMenus() {
                            $page0  =     add_menu_page( __( 'My Event Organiser Admin', 'my-event-organiser'), __( 'My Event Organiser', 'my-event-organiser' ),'','my-event-organiser-admin',array( 'MyEventOrganiser_AdminController', 'adminMenuPage'),'https://www.kevinschuit.com/images/20x20logoWit.png','3'); 
                            $page1  =     add_submenu_page ('my-event-organiser-admin',__( 'Dashboard', 'my-event-organiser' ),__( 'Dashboard', 'my-event-organiser'),'manage_options','meo_admin_dashboard', array( 'MyEventOrganiser_AdminController', 'adminSubMenuDashboard') );
                            $page2  =     
                            $page3  =     add_submenu_page ('my-event-organiser-admin',__( 'Event types', 'my-event-organiser' ),__( 'Event Types', 'my-event-organiser'),'manage_options','meo_admin_event_types', array( 'MyEventOrganiser_AdminController', 'adminSubMenuEventTypes') );
                            $page4  =     add_submenu_page ('my-event-organiser-admin', __( 'Event categorie', 'my-event-organiser' ),__( 'Event categories', 'my-event-organiser'),'manage_options','meo_admin_event_category', array( 'MyEventOrganiser_AdminController', 'adminSubMenuEventCategory'));
                            $page5  =     add_submenu_page ('my-event-organiser-admin',__( 'Apply list', 'my-event-organiser' ),__( 'Event Applicants', 'my-event-organiser'),'manage_options','meo_admin_event_apply_list',array( 'MyEventOrganiser_AdminController', 'adminSubMenuEventApplyList'));


                            // Load the JS conditionally
                            add_action( 'load-' . $page0,array('MyEventOrganiser_AdminController', 'load_admin_js') );
                            add_action( 'load-' . $page1,array('MyEventOrganiser_AdminController', 'load_admin_js') );
                            add_action( 'load-' . $page1,array('MyEventOrganiser_AdminController', 'load_admin_app_js') );
                            add_action( 'load-' . $page2,array('MyEventOrganiser_AdminController', 'load_admin_js') );
                            add_action( 'load-' . $page3,array('MyEventOrganiser_AdminController', 'load_admin_js') );
                            add_action( 'load-' . $page4,array('MyEventOrganiser_AdminController', 'load_admin_js') );
                            add_action( 'load-' . $page5,array('MyEventOrganiser_AdminController', 'load_admin_js') );
                }


             // Als de plug-in pagina laad, roep deze functie aan.
            static function load_admin_js(){
                 add_action( 'admin_enqueue_scripts',array('MyEventOrganiser_AdminController','enqueue_admin_js') );
             }

             static function load_admin_app_js(){
                add_action( 'admin_enqueue_scripts',array('MyEventOrganiser_AdminController','enqueue_admin_bs_app') );
            }
         
            // Voeg de scripts toe die je in wil laden.
            static function enqueue_admin_js(){
                 wp_enqueue_script('bootstrap1', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/js/bootstrap.bundle.js');
                 wp_enqueue_script('bootstrap2', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/js/bootstrap.esm.js');
                 wp_enqueue_script('bootstrap3', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/js/bootstrap.js');
                 wp_enqueue_script('bootstrap4', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/jquery/jquery.slim.min.js');

                 wp_enqueue_style('bootstrap1', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/css/bootstrap.css');
                 wp_enqueue_style('bootstrap2', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/css/bootstrap-utilities.css');
                 wp_enqueue_style('bootstrap3', plugin_dir_url(__FILE__).'../bootstrap-5.1.3-dist/css/bootstrap-grid.css');
                 wp_enqueue_style('admin-css', plugin_dir_url(__FILE__).'../css/adminGlobal.css');
                 
             }
            
             static function enqueue_admin_bs_app(){
                wp_enqueue_style('admin-bootstrap-min', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css');
                wp_enqueue_style('admin-bootstrap-extended', 'https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap-extended.min.css');
                wp_enqueue_style('admin-simple-line', 'https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/fonts/simple-line-icons/style.min.css');
                wp_enqueue_style('admin-colors4', 'https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/colors.min.css');
                wp_enqueue_style('admin-bootstrap4', 'https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap.min.css');
                wp_enqueue_style('gfonts', 'https://fonts.googleapis.com/css?family=Montserrat&display=swap');
             }

            // Laad de menu pagina bestanden.
            static function adminMenuPage() {
                include MY_EVENT_ORGANISER_PLUGIN_ADMIN_VIEWS_DIR . '/admin_main.php';
            }
            static function adminSubMenuEventTypes (){
                include MY_EVENT_ORGANISER_PLUGIN_ADMIN_VIEWS_DIR . '/meo_admin_event_types.php';
            }

            static function adminSubMenuEventCategory()
            {
                include MY_EVENT_ORGANISER_PLUGIN_ADMIN_VIEWS_DIR . '/meo_admin_event_category.php';
            }

            static function adminSubMenuEventApplyList()
            {
                include MY_EVENT_ORGANISER_PLUGIN_ADMIN_VIEWS_DIR . '/meo_admin_event_apply_list.php';
            }

            static function adminSubMenuDashboard(){
                include MY_EVENT_ORGANISER_PLUGIN_ADMIN_VIEWS_DIR . '/meo_admin_event_dashboard.php';
            }
    }
?>