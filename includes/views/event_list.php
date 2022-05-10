<?php
// Include model:
include MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR . "/EventList.php";

// Declare class variable:
$event_category = new EventCategory();
$event_type = new EventType();
$event = new EventList();

// Set base url to current file and add page specific vars
$base_url = get_permalink();
$params = array('page' => basename(__FILE__, ".php"));

// Add params to base url
$base_url = add_query_arg($params, $base_url);

// Get the GET data in filtered array
$get_array = $event->getGetValues();

?>


<div class="wrap">
<h2>Evenementen lijst</h2>
    <?php 
    if ($event->getNrOfEvents() < 1) {
        echo '<p class="alert alert-warning">Er zijn op dit moment geen evenementen beschikbaar.</p>';
    }else{
        $event_category_list = $event_category->getEventCategoryList();
        $event_type_list = $event_type->getEventTypeList();
        $event_list = $event->getEventList();
        ?>
<div class="row">
    <?php foreach($event_list as $event_obj) {?>
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
                    <p class="card-text">Event date: <?=$event_obj->getEventDate();?></p>
                </div>
            </div>
        </div>
<?php } ?>
</div>
<?php }?>
</div>