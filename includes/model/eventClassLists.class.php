<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
require_once (MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR. '/eventClassTables.class.php');
class eventLists{
    public function __construct(){
        $this->Tables       = new eventTables();
    }

    private function TablePrefix(){return $this->Tables->TablePrefix();}
    private function EventTypeTable(){return $this->Tables->EventTypeTable();}
    private function EventCategoryTable(){return $this->Tables->EventCategoryTable();}
    private function EventTable(){return $this->Tables->EventTable();}
    private function EventSignupTable(){return $this->Tables->EventSignupTable();}

    public function getUsersById($id) {

        global $wpdb;

        $result_array = $wpdb->get_results( "SELECT * FROM `" . $wpdb->prefix . "users` WHERE ID = $id", ARRAY_A );

        foreach ($result_array as $array) {
            $user = $array['display_name'];
        }

        return $user;
    }
    
    public function getTitleById($id) {

        global $wpdb;

        $result_array = $wpdb->get_results( "SELECT * FROM `" . $this->EventTable() . "` WHERE id_event = $id", ARRAY_A );

        foreach ($result_array as $array) {
            $title = $array['event_title'];
        }

        return $title;
    }

    public function getNrOfEventTypes(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `". $this->EventTypeTable()."`";
        $result = $wpdb->get_results( $query, ARRAY_A );

        return $result[0]['nr'];
    }

    public function getEventTypeList(){

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->EventTypeTable() ."` ORDER BY `id_event_type`", ARRAY_A);

        foreach ( $result_array as $idx => $array){

            $type = new eventBuilder();

            $type->setName($array['name']);
            $type->setId($array['id_event_type']);
            $type->setDescription($array['description']);

            $return_array[] = $type;
        }
        return $return_array;
    }

    public function getCategoryById($id) {

        global $wpdb;

        $result_array = $wpdb->get_results( "SELECT * FROM " . $this->EventCategoryTable() . " WHERE id_event_category = $id", ARRAY_A );

        foreach ($result_array as $array) {
            $category = $array['name'];
        }

        return $category;
    }

    public function getTypeById($id) {

        global $wpdb;

        $result_array = $wpdb->get_results( "SELECT * FROM " .  $this->EventTypeTable() . " WHERE id_event_type = $id", ARRAY_A );

        foreach ($result_array as $array) {
            $type = $array['name'];
        }
        return $type;
    }

    public function getNrOfEvents(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `". $this->EventTable()."`";
        $result = $wpdb->get_results( $query, ARRAY_A);

        return $result[0] ['nr'];
    }

    public function getNrOfInschrijvingen(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `". $this->EventSignupTable()."`";
        $result = $wpdb->get_results( $query, ARRAY_A);

        return $result[0] ['nr'];
    }

    public function getEventList() {

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->EventTable() . "` ORDER BY `id_event`", ARRAY_A);

        foreach ( $result_array as $idx => $array) {
        $event = new eventBuilder();

        $event->setId($array['id_event']);
        $event->setTitle($array['event_title']);
        $event->setFkEventCategory($array['fk_event_category']);
        $event->setFkEventType($array['fk_event_type']);
        $event->setEventInfo($array['event_info']);
        $event->setEventDate($array['event_date']);
        $event->setEventDueDate($array['event_due_date']);
        $event->setEventEndDate($array['event_end_date']);

        $return_array[] = $event;
        }
        return $return_array;
    }

    public function getSignupList() {

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->EventSignupTable() . "` ORDER BY `id`", ARRAY_A);

        foreach ( $result_array as $idx => $array) {
        $signup = new eventBuilder();
        $signup->setApplyId($array['id']);
        $signup->setApplyTitle($array['event_title']);
        $signup->setApplyUser($array['event_user']);

        $return_array[] = $signup;
        }
        return $return_array;
    }

    public function getNrOfEventCategories(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `". $this->EventCategoryTable()."`";
        $result = $wpdb->get_results( $query, ARRAY_A);

        return $result[0] ['nr'];
    }

    public function getEventCategoryList() {

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->EventCategoryTable() . "` ORDER BY `id_event_category`", ARRAY_A);

        foreach ( $result_array as $idx => $array) {

        $cat = new eventBuilder();

        $cat->setName($array['name']);
        $cat->setId($array['id_event_category']);
        $cat->setDescription($array['description']);


        $return_array[] = $cat;
        }
        return $return_array;
    }

}
?>