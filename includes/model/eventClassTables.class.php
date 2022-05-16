<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
// Definieer alle tabellen
class eventTables{
    // plug-in tabel prefix.
    public function TablePrefix(){
        global $wpdb;
        $prefix = 'meo_';

        return $prefix;
    }

    // Type tabel
    public function EventTypeTable(){
        global $wpdb;
        $table = $wpdb->prefix .$this->TablePrefix(). 'event_type';

        return $table;
    }
    // Category tabel
    public function EventCategoryTable(){
        global $wpdb;
        $table = $wpdb->prefix .$this->TablePrefix(). 'event_category';

        return $table;
    }
    // Event tabel
    public function EventTable(){
        global $wpdb;
        $table = $wpdb->prefix .$this->TablePrefix(). 'event';

        return $table;
    }
    // Signup tabel
    public function EventSignupTable(){
        global $wpdb;
        $table = $wpdb->prefix .$this->TablePrefix(). 'event_signup';

        return $table;
    }
}
?>