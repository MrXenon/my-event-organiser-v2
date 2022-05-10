<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
class eventTables{
    public function TablePrefix(){
        global $wpdb;
        $prefix = 'meo_';

        return $prefix;
    }

    public function EventTypeTable(){
        global $wpdb;
        $table = $wpdb->prefix .$this->TablePrefix(). 'event_type';

        return $table;
    }

    public function EventCategoryTable(){
        global $wpdb;
        $table = $wpdb->prefix .$this->TablePrefix(). 'event_category';

        return $table;
    }

    public function EventTable(){
        global $wpdb;
        $table = $wpdb->prefix .$this->TablePrefix(). 'event';

        return $table;
    }

    public function EventSignupTable(){
        global $wpdb;
        $table = $wpdb->prefix .$this->TablePrefix(). 'event_signup';

        return $table;
    }
}
?>