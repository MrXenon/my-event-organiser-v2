<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
class Tables{
    public function TablePrefix(){
        global $wpdb;
        $prefix = 'ks_';

        return $prefix;
    }

    public function UpdateTable(){
        global $wpdb;
        $table = $wpdb->prefix .$this->TablePrefix(). 'update';

        return $table;
    }

    public function ShortcodesTable(){
        global $wpdb;
        $table = $wpdb->prefix .$this->TablePrefix(). 'shortcodes';

        return $table;
    }

    public function ChoiceTable(){
        global $wpdb;
        $table = $wpdb->prefix .$this->TablePrefix(). 'choice';

        return $table;
    }

    public function AuthorTable(){
        global $wpdb;
        $table = $wpdb->prefix .$this->TablePrefix(). 'author';

        return $table;
    }
}
?>