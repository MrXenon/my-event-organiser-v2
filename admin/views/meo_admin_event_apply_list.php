<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
include MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR . "/eventClassBuilder.class.php";

// Definieer de klasse
$event_list = new eventBuilder();

// Definieer de admin url
$base_url = get_admin_url() . 'admin.php';
$params = array('page' => basename(__FILE__, ".php"));
// Wat is onze pagina naam?
$page = $params['page'];

// koppel de admin url en pagina naam samen.
$base_url = add_query_arg($params, $base_url);

// haal de URL data op.
$get_array = $event_list->getGetValues();

// Check of er een actie is voer de actie functie uit.
$action = FALSE;
if (!empty($get_array)) {
    if (isset($get_array['action'])) {
        $action = $event_list->handleGetAction($get_array);
    }
}
// Haal de post waarden op.
$post_array = $event_list->getPostValues();

// Als de actie delete is, dan voeren we de delete functie uit.
if (!empty($get_array['action'] == 'delete')) {
    $del = FALSE;
    $result = $event_list->delete($post_array);
    if ($result) {
        $del = TRUE;
    } else {
        $del = FALSE;
    }
}
?>


<div class="wrap">
<section id="minimal-statistics">
    <div class="container">
    <h1 class="text-uppercase">Applicants</h1>
    <?php

    echo (($action == 'update') ? '<form action="' . $base_url . '" method="post">' : '');
    ?>

    <?php
    // als het inschrijvngen aantal kleiner is dan 1, toon ons een warning.
    if ($event_list->getNrOfInschrijvingen() < 1) {
        echo "<p class='alert alert-warning text-center'>There are currently no registered applicants.</p>";
    ?>
        <tr>
            <td colspan="3">
        </tr>
    <?php } else {
         if (isset($del)) {
            echo ($del ? "<p class='mt-5 alert alert-success'>Applicant has been permanently deleted.</p>" : "<p class='mt-5 alert alert-danger'>Applicant could not be deleted.</p>");
        }
    ?>

    
        <table class="table table-dark mt-5">
            <thead>
                <tr>
                    <th width="400" style="text-align:left;">Event</th>
                    <th width="1000" style="text-align:left;">User</th>
                    <th width="100" colspan="2">Delete</th>
                </tr>
            </thead>
            <?php
            // koppel de app lijst.
            $app_list = $event_list->getSignupList();

            // voor elk type, maken wij een nieuw object en laaden wij dit in in onze tabel.
            foreach ($app_list as $app_list_obj) {


                $params = array('action' => 'delete', 'id' => $app_list_obj->getApplyId(), 'p' => $page);

                $del_link = add_query_arg($params, $base_url);
            ?>
                <tr>
                    <?php
                    // als de actie een update is en een ID heeft, tonen wij het update formulier
                    if (($action == 'update') && ($app_list_obj->getApplyId() == $get_array['id'])) {
                    ?>
                    <?php } else { ?>
                        <td width="100"><?php
                                        $id = $app_list_obj->getApplyUser();
                                        if (($app_list_obj->getTitleById($id)) == '') {
                                        } else {
                                            echo ($app_list_obj->getTitleById($id));
                                        }
                                        ?></td>
                        <td width="100"><?php
                                        $id = $app_list_obj->getApplyTitle();
                                        if (($app_list_obj->getUsersById($id)) == '') {
                                        } else {
                                            echo ($app_list_obj->getUsersById($id));
                                        }
                                        ?></td>
                        <?php 
                        // als de actie geen update is, dan tonen wij de tabel waarden.
                        if ($action !== 'update') {
                            // Als de actie geen update is, dan tonen wij de update en delete knopjes.
                        ?>
                            <td><a href="<?= $del_link; ?>"><div class="nftIconAdminX" data-toggle="tooltip" data-placement="bottom" title="Delete"></div></a></td>
                        <?php
                        } 
                        ?>
                    <?php } 
                    ?>
                </tr>
            <?php
            }
            ?>
        <?php }
        ?>
        </table>
        <?php
        // sluit het update formulier
        echo (($action == 'update') ? '</form>' : '');

        ?>
        </div>
        </section>
</div>