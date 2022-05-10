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
               (1, 'V1.0.0','Base toolset to manage a website.',
               '<li>Added a dashboard</li>
               <li>Imported the shortcode</li>
               <li>Inserted a javascript color switcher as a shortcode.</li>', 
               'Next update depends on the particular request');";

           dbDelta($sql);
    }

}
?>