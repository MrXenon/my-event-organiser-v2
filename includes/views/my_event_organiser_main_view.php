<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
$base_url = get_permalink();

require_once MY_EVENT_ORGANISER_PLUGIN_INCLUDES_VIEWS_DIR.'/EventView.php';
include MY_EVENT_ORGANISER_PLUGIN_CALENDAR_DIR . "/copyright.php";

$event_view = new EventView();
$cp = new Copyright();

$cc = $cp->check();

$get_inputs = $event_view->getGetValues();

$post_inputs = $event_view->getPostValues();

$current_file = (!empty($get_inputs['link']) ?
MY_EVENT_ORGANISER_PLUGIN_INCLUDES_VIEWS_DIR. '/'. $get_inputs['link'].'.php' :
'');

if (!empty($get_inputs['link'])){
    $params = array( 'link' => $get_inputs['link']);
    $file_base_url = add_query_arg( $params, $base_url );
} else {
    $file_base_url = $base_url;
}

$form_result = new WP_Error();

if ( $event_view->is_submit_event_add_form($post_inputs) ){


    $form_result = $event_view->check_event_save_form( $post_inputs );
    if ( !is_bool($form_result) && get_class($form_result) == 'WP_Error'){

    } else {
        echo "Evenement opgeslagen<br />";

         if ( !($form_result instanceof WP_Error )){

             $form_result = new WP_Error();
         }

         $event = new Event();

         $return = $event->save($post_inputs['title'],
             $post_inputs['cat'],
             $post_inputs['type'],
             $post_inputs['info'],
             $post_inputs['event_date'],
             $post_inputs['end_date'],
             $post_inputs['due_date']);

         if ( ! ($return instanceof WP_Error)) {

             $current_file = '';
         }
    }
}

if ( $event_view->is_submit_event_add_form($post_inputs) ){
}

if (!empty($current_file) && file_exists( $current_file)){

    include $current_file;

} 
else if (!empty($current_file) && !file_exists($current_file)){

    echo '<span style="color:red">Main view error: FILE NOT FOUND ['.
        $current_file .']</span>';

} 
else {

    echo '<span style="color:blue">Test Main view</span>';
    ?>
    <div>This is the main view content</div>

    <?php
    if (current_user_can('ivs_meo_event_read')) {

        if (current_user_can('ivs_meo_event_create')) {
            
            $params = array('link' => 'event_add');
           
            $link = add_query_arg($params, $base_url);
            ?>
            <a href="<?= $link; ?>">Evenementen toevoegen </a><p/>

            <?php
        }
        
        $params = array('link' => 'event_list');
       
        $link = add_query_arg($params, $base_url);
        ?>

        <a href="<?= $link; ?>">Evenementen lijst </a><p/>

        <?php
        
        $params = array('link' => 'event_apply');
       
        $link = add_query_arg($params, $base_url);
        ?>
        <a href="<?= $link; ?>">Inschrijven op evenement </a><p/>
        <?php
    } 
}
    ?>

