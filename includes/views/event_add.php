<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
if (function_exists('current_user_can') &&
    !current_user_can('ivs_meo_event_create'))
    die(__('Cheatin&#8217; uh?', 'my_event_organiser'));

require_once MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR . '/Event.php';

$event = new Event();

$event_cat_list = $event->getEventCategoryList();
$event_type_list = $event->getEventTypeList();

date_default_timezone_set('Europe/Amsterdam');

require_once(MY_EVENT_ORGANISER_PLUGIN_INCLUDES_DIR . '/calendar/classes/tc_calendar.php');
?>
<h2>Evenement aanmaken</h2>
<form action="<?= $file_base_url; ?>" method="post">
    <table>
        <tr>
            <td><?= __('Titel:'); ?></td>
            <td><input class="WidthFull" type="text" name="title" value="<?= $post_inputs['title'] ?>"/></td>
        </tr>
        <tr>
            <td><?= __('Selecteer evenement categorie:'); ?></td>
            <td><select name="cat" class="WidthFull">

                    <?php
                    foreach ($event_cat_list as $event_cat_obj) {
                        ?>
                        <option value="<?= $event_cat_obj->getId(); ?>"><?php
                            echo $event_cat_obj->getName(); ?></option>
                    <?php }
                    ?>

                </select></td>
        </tr>
        <tr>
            <td><?= __('Selecteer inschrijvingstype:'); ?></td>
            <td><select name="type" class="WidthFull">

                    <?php
                    foreach ($event_type_list as $event_type_obj) {
                        ?>
                        <option value="<?= $event_type_obj->getId(); ?>"><?php
                            echo $event_type_obj->getName(); ?></option>
                    <?php }
                    ?>

                </select></td>
        </tr>
        <tr>
            <td><?= __('Evenement datum:<br />'); ?></td>
            <td>
                <?php
                $calendar_dir = site_url() . "/wp-content/plugins/my-event-organiser/includes/calendar/";

                $event_date_default = is_null($post_inputs['event_date']) ? Date("Y-m-d") : $post_inputs['event_date'];
                $end_date_default = is_null($post_inputs['end_date']) ? '' :
                    $post_inputs['end_date'];
                $due_date_default = is_null($post_inputs['due_date']) ? Date("Y-m-d") :
                    $post_inputs['due_date'];

                $myCalendar = new tc_calendar("event_date", true /*, false */);
                $myCalendar->setIcon($calendar_dir . "/images/iconCalendar.gif");
                $myCalendar->setDate(date('d', strtotime($event_date_default))
                    , date('m', strtotime($event_date_default))
                    , date('Y', strtotime($event_date_default)));
                $myCalendar->setPath($calendar_dir);
                $myCalendar->setYearInterval(Date("Y"), intval(Date("Y")) + 5);
                $myCalendar->setAlignment('left', 'bottom');
                $myCalendar->setDatePair('event_date', 'end_date', $end_date_default);
                $myCalendar->writeScript();

                $myCalendar = new tc_calendar("end_date", true /*, false */);
                $myCalendar->setIcon($calendar_dir . "images/iconCalendar.gif");
                $myCalendar->setDate(date('d', strtotime($end_date_default))
                    , date('m', strtotime($end_date_default))
                    , date('Y', strtotime($end_date_default)));
                $myCalendar->setPath($calendar_dir);
                $myCalendar->setYearInterval(Date("Y"), intval(Date("Y")) + 5);
                $myCalendar->setAlignment('left', 'bottom');
                $myCalendar->setDatePair('event_date', 'end_date', $event_date_default);

                ?><span class="error"><?= $form_result->get_error_message('event_date'); ?></span></td>
        </tr>
        <tr>
            <td><?= __('Eind datum: <br />'); ?></td>
            <td>

                <?php
                $myCalendar->writeScript();
                ?><span class="error">
                <?= $form_result->get_error_message('end_date');
                ?></span></td>

        </tr>
        <tr>
            <td><?= __('Uiterlijke inschrijfdatum'); ?></td>
            <td>

                <?php
                $myCalendar = new tc_calendar("due_date", true);
                $myCalendar->setIcon($calendar_dir . "images/iconCalendar.gif");
                $myCalendar->setDate(date('d', strtotime($due_date_default))
                    , date('m', strtotime($due_date_default))
                    , date('Y', strtotime($due_date_default)));
                $myCalendar->setPath($calendar_dir);
                $myCalendar->setYearInterval(Date("Y"), intval(Date("Y")) + 10);
                $myCalendar->dateAllow(Date("Y") . '-01-01', (intval(Date("Y")) + 2) . '-01-01');
                $myCalendar->writeScript(); ?><span
                        class="error"><?= $form_result->get_error_message('due_date'); ?></span></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td><?= __('Extra informatie:'); ?></td>
            <td><textarea
                        name="info" rows="4" cols="5"><?=
                    $post_inputs['info']; ?></textarea>
                <span class="error"><?= $form_result->get_error_message('info'); ?></span></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="add_event"
                       value="<?= __('Aanmaken'); ?>"  <?= $cc; ?>/></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
</form>