<?php
//Include model:

include MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR. "/eventClassBuilder.class.php";
include MY_EVENT_ORGANISER_PLUGIN_CALENDAR_DIR . "/copyright.php";

//Declare class variable:
$event_categories = new eventBuilder();
$cp = new Copyright();
$cc = $cp->check();

//Set base url to current file and add page specific vars
$base_url = get_admin_url().'admin.php';
$params = array( 'page' => basename(__FILE__,".php"));

$page = $params['page'];

//Add params to base url
$base_url = add_query_arg( $params, $base_url );

//Get the GET data in filtered array
$get_array = $event_categories->getGetValues();

//Keep track of current action
$action = FALSE;

if (!empty($get_array)) {

    //Check actions
    if (isset($get_array['action'])) {
        $action = $event_categories->handleGetAction($get_array);
    }
}

//Get the POST data in filtered array
$post_array = $event_categories->getPostValues();

//Collect Errors
$error = FALSE;

//Check the POST data
if (!empty($post_array)){

    //Check the add form:
    $add = FALSE;
    if (isset($post_array['add']) ){
        // Save event categorie
        $result = $event_categories->save($post_array);
        if ($result){
            //Save was succesfull
            $add = TRUE;
        } else {
            //Indicate error
            $error = TRUE;
        }
    }

    //Check the update form:
    if (isset($post_array['update']) ){
        //Save event categorie
        $event_categories->update($post_array);
    }
}

?>
<div class="wrap">
        Admin event categorie CRUD.<br />
        (Uitje, excursie, etc)
<?php

if(isset($add)){
    echo ($add ? "<p>Added a new event</p>" : "");
}

    //Check if action == update: then start update form
    echo (($action == 'update') ? '<form action="'.$base_url.'"method="post">' : '');
    ?>

    <table class="table table-dark">
        <caption>Event type categories</caption>
            <thead>
                <tr>
                    <th width="10">Id</th>
                    <th width="150">Name</th>
                    <th width="200">Description</th>
                    <th colspan="2" width="200">Actions</th>
                </tr>
            </thead>
    <?php
//*
 if( $event_categories->getNrOfEventCategories() < 1){
?>
 <tr><td colspan="3">Start adding Event Categories</tr>
<?php 
 } else {
     $cat_list = $event_categories->getEventCategoryList(); 

     //** Show all event categories in the tabel */
     foreach( $cat_list as $event_cat_obj){
         
        //Create update link
        $params = array( 'action' => 'update', 'id' => $event_cat_obj->getId());
        //Add params to base url update link
        $upd_link = add_query_arg( $params,  $base_url );

        //Create delete link
        $params = array( 'action' => 'delete', 'id' => $event_cat_obj->getId());

        //Add params to base url delete link
        $del_link = add_query_arg( $params, $base_url);

         ?>
     <tr><td width="10"><?= $event_cat_obj->getId(); ?></td>
<?php 
     //If update and id match show update form
     //Add hidden field id for id transfer
     if (   ($action == 'update') && 
            ($event_cat_obj->getId() == $get_array['id']) ){ 
?>
    <td width="180"><input type="hidden" name="id" value="<?= $event_cat_obj->getId(); ?>">
    <input type="hidden" value="<?=$page;?>" name="p">
        <input type="text" name="name" value="<?= $event_cat_obj->getName(); ?>"></td>
    <td width="200"><input type="text" name="description" value ="<?= $event_cat_obj->getDescription();?>"></td>
    <td colspan="2"><input type="submit" name="update" value="Updaten" <?= $cc; ?>/></td>

    <?php } else {  ?>
        <td width="180"><?= $event_cat_obj->getName(); ?></td>
        <td width="200"><?= $event_cat_obj->getDescription();?></td>
        <?php if ($action !=='update') {
            //If action is update don't show the action button
        ?>
        <td><a href="<?= $upd_link; ?>">Update</a></td>
        <td><a href="<?= $del_link; ?>">Delete</a></td>
    <?php
            } //if action !== update
    ?>
    <?php } // if action !== update ?>
     </tr>
    <?php   }   }
    ?>

    </table>
    <?php
    echo (($action == 'update') ? '</form>' : '');
    /** Finally add the new entery line only if no update action  **/
    if ($action !== 'update'){
    ?>

    <form action="<?= $base_url; ?>" method="post"><tr>
        <table>
            <tr><td colspan="2">
                    <input type="text" name="name">
                    <input type="hidden" value="<?=$page;?>" name="p"></td>
                <td><input type="text" name="description"></td></tr>
            <tr><td colspan="2"><input type="submit" name="add" <?= $cc; ?> value="Toevoegen"/></td>
            </tr>
        </table>
    </form>
    <?php
    } 
    ?>
</div>