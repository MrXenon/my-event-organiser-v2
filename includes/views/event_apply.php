<?php
// Include model:
include MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR . "/EventList.php";

// Declare class variable:
$event_category = new EventCategory();
$event_type = new EventType();
$event = new EventList();

// Set base url to current file and add page specific vars
$base_url = get_permalink();
$params = array('link' => basename(__FILE__, ".php"));

// Add params to base url
$base_url = add_query_arg($params, $base_url);

// Get the GET data in filtered array
$get_array = $event->getGetValues();

// Keep track of current action.
$action = FALSE;
if (!empty($get_array)) {

    // Check actions
    if (isset($get_array['action'])) {
        $action = $event->handleGetAction($get_array);
    }
}

/* Na checken     */
// Get the POST data in filtered array
$post_array = $event->getPostValues();

// Collect Errors
$error = FALSE;
// Check the POST data
if (!empty($post_array['add'])) {

    // Check the add form:
    $add = FALSE;
    // Save event types
    $result = $event->save($post_array);
    if ($result) {
        // Save was succesfull
        ?>
        <script>window.location.replace("<?=$base_url;?>");</script>
        <?php
    } else {
        // Indicate error
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
                    <form action="<?= $base_url; ?>" method="post">
                    <input type="hidden" name="gebruiker" value="<?= get_current_user_id();?>">
                    <input type="hidden" name="eventTitel" value="<?=$event_obj->getId();?>">
                    <?php 
                    if($event_obj->getEventDueDate() < date('Y-m-d')){
                        echo '<p class="alert alert-danger">Inschrijf datum is verstreken.</p>';
                    }else{ ?>
                    <input type="submit" class="btn btn-primary" name="add" value="Inschrijven" <?= $cc; ?>/>
                    <?php } ?>
                    </form>
                </div>
            </div>
        </div>
<?php } ?>
</div>
<?php }?>
</div>