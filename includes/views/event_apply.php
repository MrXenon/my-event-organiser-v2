<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
include_once MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR . "/eventClassBuilder.class.php";

$event = new eventBuilder();

$base_url = get_permalink();
$params = array('link' => basename(__FILE__, ".php"));
$page = basename(__FILE__, ".php");

$base_url = add_query_arg($params, $base_url);

$get_array = $event->getGetValues();

$action = FALSE;
if (!empty($get_array)) {

    if (isset($get_array['action'])) {
        $action = $event->handleGetAction($get_array);
    }
}

$post_array = $event->getPostValues();

$error = FALSE;

if (!empty($post_array['add'])) {

    $add = FALSE;

    $result = $event->save($post_array);
    if ($result) {
        ?>
        <script>
         window.location.replace("<?=$base_url;?>");
        </script>
        <?php
    } else {

        $error = TRUE;
    }
}
?>
<div class="wrap">
<h2>Inschrijven op Evenement</h2>
    <?php 
    if ($event->getNrOfEvents() < 1) {
        echo '<p class="alert alert-warning">Er zijn op dit moment geen evenementen beschikbaar.</p>';
    }else{
        $eventCat_list = $event->getEventCategoryList();
        $eventType_list = $event->getEventTypeList();
        $eventList_list = $event->getEventList();
        ?>
<div class="row">
    <?php foreach($eventList_list as $event_obj) {?>
        <div class="col-3">
            <div class="card" style="width: 18rem;">
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
                    <p class="card-text">Evenement datum: <?=date("d-m-Y", strtotime($event_obj->getEventDate()));?></p>
                    <form action="<?= $base_url; ?>" method="post">
                    <input type="hidden" name="p" value="<?=$page;?>">
                    <input type="hidden" name="gebruiker" value="<?= get_current_user_id();?>">
                    <input type="hidden" name="eventTitel" value="<?=$event_obj->getId();?>">
                    <?php 
                    if($event_obj->getEventDueDate() < date('Y-m-d')){
                        echo '<p class="alert alert-danger">Inschrijf datum is verstreken.</p>';
                    }else{ ?>
                    <input type="submit" class="btn btn-primary WidthFull" name="add" value="Inschrijven" <?= $cc; ?>/>
                    <?php } ?>
                    </form>
                </div>
            </div>
        </div>
<?php } ?>
</div>
<?php }?>
</div>