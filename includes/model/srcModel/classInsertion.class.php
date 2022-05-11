<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
class Insertion{
    public static function buildSourceTables()
    {

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        //Calling $wpdb;
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $prefix = 'ks_';

        //Name of the table that will be added to the db
        $shortcodes		    =	 $wpdb->prefix .$prefix. "shortcodes";
        $author			    =	 $wpdb->prefix .$prefix. "author";
        $updateLog		    =	 $wpdb->prefix .$prefix. "update";
        $choice             =    $wpdb->prefix .$prefix. "choice";

        $wpdb->query("DROP TABLE $shortcodes");

        $sql = "CREATE TABLE IF NOT EXISTS $shortcodes (
           sid BIGINT(11) NOT NULL AUTO_INCREMENT,
           short_name VARCHAR(64) NOT NULL,
           short_desc VARCHAR(1024) NOT NULL,
           PRIMARY KEY  (sid))
           ENGINE = InnoDB $charset_collate";
        dbDelta($sql);

        $wpdb->query("DROP TABLE $author");

        $sql = "CREATE TABLE IF NOT EXISTS $author (
           aid BIGINT(11) NOT NULL AUTO_INCREMENT,
           author_name VARCHAR(64) NOT NULL,
           author_email VARCHAR(64) NOT NULL,
           author_website VARCHAR(64) NOT NULL,
           PRIMARY KEY  (aid))
           ENGINE = InnoDB $charset_collate";
        dbDelta($sql);


       $wpdb->query("DROP TABLE $updateLog");

       $sql = "CREATE TABLE IF NOT EXISTS $updateLog (
           uid BIGINT(11) NOT NULL AUTO_INCREMENT,
           update_version VARCHAR(64) NOT NULL,
           update_desc VARCHAR(2048) NOT NULL,
           update_list TEXT(2048) NOT NULL,
           future_desc VARCHAR(2048) NOT NULL,
           PRIMARY KEY  (uid))
           ENGINE = InnoDB $charset_collate";
       dbDelta($sql);    

       $wpdb->query("DROP TABLE $choice");

       $sql = "CREATE TABLE IF NOT EXISTS $choice (
           choice_id BIGINT(11) NOT NULL AUTO_INCREMENT,
           choice_name VARCHAR(64) NOT NULL,
           choice_var VARCHAR(1) NOT NULL,
           PRIMARY KEY  (choice_id))
           ENGINE = InnoDB $charset_collate";
       dbDelta($sql);  

       $sql = "INSERT INTO `$shortcodes` (`sid`, `short_name`,`short_desc`) VALUES
           (1, '[my_event_organiser_main_view]','This shortcode when included, shows us the my event organiser main view');";
       dbDelta($sql);

       $sql = "INSERT INTO `$choice` (`choice_id`, `choice_name`,`choice_var`) VALUES
           (1, 'Yes','1'),
           (2, 'No','0');";
       dbDelta($sql);
       

       $sql = "INSERT INTO `$author` (`aid`, `author_name`,`author_email`,`author_website`) VALUES
           (1, 'Kevin Schuit','info@kevinschuit.com','https://kevinschuit.com');";
       dbDelta($sql);

           $sql = "INSERT INTO `$updateLog` (`uid`, `update_version`,`update_desc`,`update_list`,`future_desc`) VALUES
               (1, 'V1.0.0','Base version of the my Event Organiser, current version is based on PHP 7.4 & PHP 8.0 for Wordpress 5.9.3.',
               '<li>Added a dashboard.</li>
               <li>Imported the shortcode.</li>
               <li>Inserted dashboard builder.</li>
               <li>Reworked the event class files to stack similar functions.</li>
               <li>Added wordpress plugin update by Github repository version.</li>
               <li>Inserted stylesheet through SCSS.</li>
               <li>Split admin only bootstrap & front-end file bootstrap.</li>
               <li>Included bootstrap in front-end MEO plug-in.</li>
               <li>Updated event_list.php</li>
               <li>Updated event_apply.php</li>
               <li>Updated event_add.php</li>
               <li>Updated meo_admin_event_apply_list.php</li>
               <li>Updated meo_admin_event_category.php</li>
               <li>Updated meo_admin_event_types.php</li>
               <li>loaded icons folder in plug-in.</li>
               <li>Require user role editor plug-in, else add option to return or install the plug-in on click.</li>
               <li>Reverted MEO aspects back to original dataset.</li>
               <li>Added a button to the my event organiser page in the dashboard.</li>
               <li>On plug-in activation, create the My Event Organiser front-end page & add our shortcode to it.</li>
               <li>On plug-in deactivation delete our database plug-in tables & remove our plug-in front-end page.</li>
               <li>Plug-in displays tutorial site, support button & Dashboard button on plug-in page.</li>
               <li>Current code is based on PHP 7.4 & 8.0, certain functions will be deprecated in 8.1, due to this the newer functions are added in comments near the current code.</li>', 
               'Next update includes a new calendar or a reworked version of the current one as the current version breaks with updated javascript');";

           dbDelta($sql);
    }

}
