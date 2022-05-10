<?php
// Include model:
include MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR . "/EventList.php";

// Declare class variable:
$event_list = new EventList();

// Set base url to current file and add page specific vars
$base_url = get_admin_url() . 'admin.php';
$params = array('page' => basename(__FILE__, ".php"));

$page = $params['page'];

// Add params to base url
$base_url = add_query_arg($params, $base_url);

// Get the GET data in filtered array
$get_array = $event_list->getGetValues();

// Keep track of current action.
$action = FALSE;
if (!empty($get_array)) {

    // Check actions
    if (isset($get_array['action'])) {
        $action = $event_list->handleGetAction($get_array);
    }
}

/* Na checken     */
// Get the POST data in filtered array
$post_array = $event_list->getPostValues();
?>


<div class="wrap">
    <h1>Inschrijvingen</h1>

    <?php
    // Check if action == update : then start update form
    echo(($action == 'update') ? '<form action="' . $base_url . '" method="post">' : '');
    ?>
        <!-- <tr><td colspan="3">Event types rij 1</td></tr> -->
        <?php
        //*
        if ($event_list->getNrOfInschrijvingen() < 1) {
            echo 'Er zijn op dit moment geen inschrijvingen.';
            ?>
            <tr>
                <td colspan="3">
            </tr>
        <?php } else {
            ?>
            <table>
                <thead>
                <tr>
                    <th width="200" style="text-align:left;">Titel</th>
                    <th width="100" style="text-align:left;">Gebruiker</th>
                </tr>
                </thead>
            <?php
            $app_list = $event_list->getSignupList();

            //** Show all event types in the tabel
            foreach ($app_list as $app_list_obj) {

                // Create delete link
                $params = array('action' => 'delete', 'id' => $app_list_obj->getApplyId());

                // Add params to base url delete link
                $del_link = add_query_arg($params, $base_url);
                ?>
                <tr>
                    <?php
                    // If update and id match show update form
                    // Add hidden field id for id transfer
                    if (($action == 'update') && ($app_list_obj->getApplyId() == $get_array['id'])) {
                        ?>
                    <?php } else { ?>
                        <td width="100"><?php
                        $id = $app_list_obj->getApplyUser();
                        if(($app_list_obj->getTitleById($id)) == '') {

                        }else {
                            echo($app_list_obj->getTitleById($id));
                        }
                        ?></td>
                        <td width="100"><?php
                        $id = $app_list_obj->getApplyTitle();
                        if(($app_list_obj->getUsersById($id)) == '') {

                        }else {
                            echo($app_list_obj->getUsersById($id));
                        }
                        ?></td>
                        <?php if ($action !== 'update') {
                            // If action is update don’t show the action button
                            ?>
                            <td><a href="<?= $del_link; ?>">Delete</a></td>
                            <?php
                        } // if action !== update
                        ?>
                    <?php } // if acton !== update ?>
                </tr>
                <?php
            }
            ?>
        <?php }
        ?>
    </table>
    <?php
    // Check if action = update : then end update form
    echo(($action == 'update') ? '</form>' : '');
    /** Finally add the new entry line only if no update action **/
    ?>
</div>