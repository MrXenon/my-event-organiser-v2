<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
require_once MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR . '/eventClassBuilder.class.php';

class Event
{
    // instantieert de eventBuilder klasse
    private $eventBuilder = null;

    // Laat de eventBuilder klasse in
    public function __construct()
    {
        $this->eventBuilder = new eventBuilder();
    }

    // Haal de category lijst op.
    public function getEventCategoryList()
    {
        return $this->eventBuilder->getEventCategoryList();
    }
    // Haal de type lijst op
    public function getEventTypeList()
    {
        return $this->eventBuilder->getEventTypeList();
    }
    // Check value, anders toon ons een exceptie.
    public function checkEventTitle($title)
    {
        if (!is_string($title)) throw new Exception (__('Tekst invullen'));

        if (empty($title)) throw new Exception (__('Verplicht veld!'));
    }
    // Check value, anders toon ons een exceptie.
    public function checkCat($cat)
    {
        if (!is_numeric($cat)) throw new Exception (__('Categorie link incorrect'));

        if (strlen($cat) < 1) throw new Exception (__('Verplicht veld!'));
    }
    // Check value, anders toon ons een exceptie.
    public function checkType($type)
    {
        if (!is_numeric($type)) throw new Exception (__('Type link incorrect'));

        if (strlen($type) < 1) throw new Exception (__('Verplicht veld!'));
    }
    // Check value, anders toon ons een exceptie.
    public function checkDate($date, $empty = FALSE)
    {
        if (!$empty && strlen($date) < 1) throw new Exception (__('Verplicht veld'));

        if (!is_string($date)) throw new Exception (__('Datum tekst formaat yyyy-mm-dd'));
        //@todo check date format
    }
    // Check value, anders toon ons een exceptie.
    public function checkInfo($info)
    {
        if (!is_string($info)) throw new Exception(__('Tekst invullen'));
    }
    // Start de save functie
    function save($title, $cat, $type, $info, $event_start_date,
                  $event_end_date, $event_due_date)
    {

        global $wpdb;
        $error = new WP_Error();

        try {
            $this->checkEventTitle($title);
            $this->checkCat($cat);
            $this->checkType($type);
            $this->checkInfo($info);
            $this->checkDate($event_start_date);
            $this->checkDate($event_end_date, TRUE);
            $this->checkDate($event_due_date, TRUE);
        } catch (Exception $exc) {
            $error->add('save', $exc->getMessage());
        }

        // check op errors, zijn er geen, dan slaan we de data op.
        if (count($error->get_error_messages()) < 1) {

            $sql = $wpdb->prepare("INSERT INTO `" . $wpdb->prefix . "meo_event`" .
                "( `event_title`, `fk_event_category`, `fk_event_type`, " .
                "`event_info`, `event_date`, `event_due_date`,`event_end_date`)" .
                " VALUES ( '%s', '%d', '%d', '%s', '%s', " .
                (strlen($event_due_date) ? "'%s'" : 'null') . ", " . // Could be NULL
                (strlen($event_end_date) ? "'%s'" : 'null') . // Could be NULL
                ");",
                $title, $cat, $type, $info, $event_start_date,
                (strlen($event_due_date) ? $event_due_date : 'null'), // Could be NULL
                (strlen($event_end_date) ? $event_end_date : 'null' )// Could be NULL
            );

            // Voer de SQL uit
            $wpdb->query($sql);

            // Is er een error? Toon ons de laatste error.
            if (!empty($wpdb->last_error)) {
                $this->last_error = $wpdb->last_error;
                $error->get_error_message($this->last_error);

                return $error;
            }

        } else {
            return $error;
        }
        return $wpdb->insert_id;
    }
}
