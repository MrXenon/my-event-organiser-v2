<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
require_once MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR . "/eventClassBuilder.class.php";

// Definieer de klasse
$event = new eventBuilder();

// Maak de pagina url aan
$base_url = get_permalink();
$params = array('page' => basename(__FILE__, ".php"));

// Koppel de pagina url data
$base_url = add_query_arg($params, $base_url);

// Haal de URL waarden op
$get_array = $event->getGetValues();

?>


<div class="wrap">
<h2>Evenementen lijst</h2>
    <?php 
    // Check of event aantal kleiner is dan 1
    if ($event->getNrOfEvents() < 1) {
        echo '<p class="alert alert-warning">Er zijn op dit moment geen evenementen beschikbaar.</p>';
    }else{
        // Haal de lijsten op
        $eventCat_list = $event->getEventCategoryList();
        $eventType_list = $event->getEventTypeList();
        $eventList_list = $event->getEventList();
        ?>
<div class="row">
    <?php 
    // Bouw de evenementen lijst visueel op.
    foreach($eventList_list as $event_obj) {?>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?=$event_obj->getTitle();?></h4>
                    <hr>
                    <p>
                    <?php $id = $event_obj->getEventCategory();
                        if(($event_obj->getCategoryById($id)) == '') {
                            
                        }else {
                            echo($event_obj->getCategoryById($id));
                        }
                        ?>
                    </p>
                    <p>
                    <?php $id = $event_obj->getEventType();
                        if(($event_obj->getTypeById($id)) == '') {

                        }else {
                            echo($event_obj->getTypeById($id));
                        }
                        ?>
                    </p>
                    <hr>
                    <p class="card-text"><?=$event_obj->getEventInfo();?></p>
                    <p class="card-text">Event date: <?=$event_obj->getEventDate();?></p>
                </div>
            </div>
        </div>
<?php } ?>
</div>
<?php }?>
</div>