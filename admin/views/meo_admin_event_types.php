<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
// Include model:
include MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR. "/eventClassBuilder.class.php";

$builder = new eventBuilder();

$base_url = get_admin_url() . 'admin.php';
$params = array('page' => basename(__FILE__, ".php"));
$page = basename(__FILE__, ".php");

$base_url = add_query_arg($params, $base_url);


$get_array = $builder->getGetValues();


$action = FALSE;
if (!empty($get_array)) {

    if (isset($get_array['action'])) {
        $action = $builder->handleGetAction($get_array);
    }
}


$post_array = $builder->getPostValues();


$error = FALSE;

if (!empty($post_array['add'])) {


    $add = FALSE;

        $result = $builder->save($post_array);
        if ($result) {
            $add = TRUE;
        } else {

            $error = TRUE;
        }
}

if (!empty($post_array['update'])) {


    $update = FALSE;

    $result = $builder->update($post_array);
    if ($result) {

        $update = TRUE;
    } else {

        $update = FALSE;
    }
}

if (!empty($get_array['action'] == 'delete')) {

    $del = FALSE;

    $result = $builder->delete($post_array);
    if ($result) {

        $del = TRUE;
    } else {

        $del = FALSE;
    }
}
?>

<div class="container-fluid">
<section id="minimal-statistics">
    <h4 class="text-uppercase">Event Types</h4>
</div>
    <div class="container">
    <?php
    if (isset($add)) {
        echo($add ? "<p class='mt-5 alert alert-success'>".$_POST['name']." has been added.</p>" : "<p class='mt-5 alert alert-danger'>Type could not be added.</p>");
    }

    if (isset($update)) {
        echo($update ? "<p class='mt-5 alert alert-success'>".$_POST['name']." has been updated.</p>" : "<p class='mt-5 alert alert-danger'>Type could not be updated.</p>");
    }

    if (isset($del)) {
        echo($del ? "<p class='mt-5 alert alert-success'>Type has been permanently deleted.</p>" : "<p class='mt-5 alert alert-danger'>Type could not be deleted.</p>");
    }

        if ($action !== 'update') {
            ?>
            <div class="row mb-5" id="formDiv">
                <form class="row g-3 needs-validation" method="post" action="<?=$base_url;?>" validate>
                    <div class="col-md-4 position-relative">
                        <input type="hidden" name="p" value="<?=$page;?>">
                        <label for="validationCustom01" class="form-label">Name:</label>
                        <input type="input" class="form-control" maxlength="7" name="name" id="validationCustom01" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid type.
                        </div>
                    <label for="validationCustom02" class="form-label">Description:</label>
                        <textarea name="description" rows="10" class="form-control"></textarea>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid description.
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="add" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
            <?php
        } 
    echo(($action == 'update') ? '<form action="' . $base_url . '" method="post">' : '');
    ?>
<div>
    <table class="table table-light" id="networkDiv">
        <?php
        if ($builder->getNrOfEventTypes() < 1) {
            ?>
        <p class='alert alert-warning'>No event type has been added yet!</p>
        <?php } else { ?>
            <thead>
                <tr>
                    <th width="400">Type</th>
                    <th width="2000">Description</th>
                    <th width="200" colspan="2">Actions</th>
                </tr>
            </thead>
            <?php
            $colors = $builder->getEventTypeList();

            foreach ($colors as $builder_obj) {
                $params = array('action' => 'update', 'id' => $builder_obj->getId());
                $upd_link = add_query_arg($params, $base_url);

                $params = array('action' => 'delete', 'id' => $builder_obj->getId(), 'p' => $page);
                $del_link = add_query_arg($params, $base_url);
                ?>

                <tr>
                    <?php
                    if (($action == 'update') && ($builder_obj->getId() == $get_array['id'])) {
                        ?>
                <div class="row">
                <div class="col-md-4 position-relative">
                        <input type="hidden" name="p" value="<?=$page;?>">
                        <input type="hidden" name="id" value="<?=$builder_obj->getId();?>">
                        <label for="validationCustom01" class="form-label">Name:</label>
                        <input type="input" class="form-control" maxlength="7" name="name" id="validationCustom01" required value="<?=$builder_obj->getName();?>">
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid type.
                        </div>
                    <label for="validationCustom02" class="form-label">Description:</label>
                        <textarea name="description" rows="10" class="form-control"><?=$builder_obj->getDescription();?></textarea>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid description.
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="update" class="btn btn-primary" value="Update">
                    </div>
                    </div>
                    <?php } else { ?>
                        <td width="400"><?= $builder_obj->getName(); ?></td>
                        <td width="2000"><?= $builder_obj->getDescription(); ?></td>
                        <?php if ($action !== 'update') {
                            ?>
                            <td><a href="<?= $upd_link; ?>"><div class="nftIconAdminCheck" data-toggle="tooltip" data-placement="bottom" title="Edit"></div></a></td>
                            <td><a href="<?= $del_link; ?>" onclick="return confirm('Are you sure you want to permanently delete this network?');"><div class="nftIconAdminX" data-toggle="tooltip" data-placement="bottom" title="Delete"></div></a></td>
                            <?php
                        } 
                        ?>
                    <?php }  ?>
                </tr>
                <?php
            }
            ?>
        <?php }
        ?>
    </table>
</div>
    <?php
    echo(($action == 'update') ? '</form>' : '');
?>
  </section>
</div>