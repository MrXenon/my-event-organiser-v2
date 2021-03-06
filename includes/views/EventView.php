<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
require_once MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR .'/Event.php';

class EventView{

    private $event;

    // Laad het event
    public function __construct() {
        $this->event = new Event();
    }

    public function getGetValues(){
        //Definieer de check parameters.
        $get_check_array = array (
            'link' => array('filter' => FILTER_SANITIZE_STRING )
        );
        return filter_input_array( INPUT_GET, $get_check_array );
    }
    // haal de post data op
    public function getPostValues(){
        $post_check_array = array (
            'add_event' => array('filter' => FILTER_SANITIZE_STRING ),
            'title' => array('filter' => FILTER_SANITIZE_STRING ),
            'cat' => array('filter' => FILTER_SANITIZE_NUMBER_INT ),
            'type' => array('filter' => FILTER_SANITIZE_NUMBER_INT ),
            'info' => array('filter' => FILTER_SANITIZE_STRING ),
            'event_date' => array('filter' => FILTER_SANITIZE_STRING ),
            'end_date' => array('filter' => FILTER_SANITIZE_STRING ),
            'due_date' => array('filter' => FILTER_SANITIZE_STRING )
        );
        // Filter de input
        $post_inputs = filter_input_array( INPUT_POST, $post_check_array );

        return $post_inputs;
    }

    // check of het formulier ingestuurd is.
    public function is_submit_event_add_form( $post_inputs ){
        if (!is_null($post_inputs['add_event'])) return TRUE;

        return FALSE;
    }

    // check of de waarden ingevoerd zijn
    public function check_event_save_form ( &$post_inputs )
    {
        // Special wordpress error class
        $errors = new WP_Error();

        // Title
        try {
            $this->event->checkEventTitle($post_inputs['title']);
        } catch (Exception $exc) {
            $errors->add('title', $exc->getMessage());
        }

        // Categorie ID
        try {
            $this->event->checkCat($post_inputs['cat']);
        } catch (Exception $exc) {
            $errors->add('cat', $exc->getMessage());
        }
        // Type ID
        try {
            $this->event->checkType($post_inputs['type']);
        } catch (Exception $exc) {
            $errors->add('type', $exc->getMessage());
        }

        // Info
        try {
            $this->event->checkInfo($post_inputs['info']);
        } catch (Exception $exc) {
            $errors->add('info', $exc->getMessage());
        }

        // Check dates
        $dates = array( 'event_date',
            'end_date',
            'due_date');
        foreach( $dates as $date_field ){
            try {
               // End date kan leeg zijn
                $date_empty = !($date_field == 'end_date');
                $this->event->checkDate($post_inputs[$date_field],
                    $date_empty);
                // Als date gelijk is aan 0000-00-00 verander naar ''
                if (!$date_empty && (strcmp($post_inputs[$date_field] ,'0000-00-00') == 0 )){
                    $post_inputs[$date_field] = '';
                }
            } catch (Exception $exc) {
                $errors->add($date_field, $exc->getMessage());
            }
        }

        // Check of errors voor het opslaan
        if ($errors->get_error_code()) return $errors;
        return TRUE; // geef resultaat terug.
    }

}
?>