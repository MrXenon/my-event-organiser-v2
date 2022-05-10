<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
require_once MY_EVENT_ORGANISER_PLUGIN_MODEL_SRC_DIR  . '/classTables.class.php';
class Lists{
    public function __construct(){
        $this->Tables          = new Tables();
    }
    // Define tables
    private function TablePrefix(){return $this->Tables->TablePrefix();}
    private function UpdateTable(){return $this->Tables->UpdateTable();}
    private function ShortcodesTable(){return $this->Tables->ShortcodesTable();}
    private function ChoiceTable(){return $this->Tables->ChoiceTable();}
    private function AuthorTable(){return $this->Tables->AuthorTable();}

    public function getKSChoiceList(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->ChoiceTable() ."` ORDER BY `choice_id`", ARRAY_A);

        foreach ( $result_array as $idx => $array){

            $builder = new classBuilder();

            $builder->setChoiceId($array['choice_id']);
            $builder->setChoice($array['choice_name']);
            $builder->setChoiceVar($array['choice_var']);

            $return_array[] = $builder;
        }
        return $return_array;
    }

    public function getKSShortcodes(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->ShortcodesTable() ."`  ORDER BY `sid`", ARRAY_A);

        foreach ( $result_array as $idx => $array){

            $builder = new classBuilder();

            $builder->setShortcodeId($array['sid']);
            $builder->setShortcodeName($array['short_name']);
            $builder->setShortcodeDesc($array['short_desc']);

            $return_array[] = $builder;
        }
        return $return_array;
    }

    public function getKSAuthor(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->AuthorTable() ."`  ORDER BY `aid`", ARRAY_A);

        foreach ( $result_array as $idx => $array){

            $builder = new classBuilder();

            $builder->setAuthorId($array['aid']);
            $builder->setAuthorName($array['author_name']);
            $builder->setAuthorMail($array['author_email']);
            $builder->setAuthorSite($array['author_website']);

            $return_array[] = $builder;
        }
        return $return_array;
    }

    public function getKSUpdateLog(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->UpdateTable() ."`  ORDER BY `uid`", ARRAY_A);

        foreach ( $result_array as $idx => $array){

            $builder = new classBuilder();

            $builder->setUpdateId($array['uid']);
            $builder->setUpdateVersion($array['update_version']);
            $builder->setUpdateDesc($array['update_desc']);
            $builder->setUpdateList($array['update_list']);
            $builder->setUpdateFdesc($array['future_desc']);

            $return_array[] = $builder;
        }
        return $return_array;
    }

    public function getKSChangeLog(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->UpdateTable() ."` ORDER BY `uid` DESC LIMIT 1", ARRAY_A);

        foreach ( $result_array as $idx => $array){

            $builder = new classBuilder();

            $builder->setUpdateId($array['uid']);
            $builder->setUpdateVersion($array['update_version']);
            $builder->setUpdateDesc($array['update_desc']);
            $builder->setUpdateList($array['update_list']);
            $builder->setUpdateFdesc($array['future_desc']);


            $return_array[] = $builder;
        }
        return $return_array;
    }
}
?>