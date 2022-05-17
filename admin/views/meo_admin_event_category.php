<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
include MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR . "/eventClassBuilder.class.php";
// Definieer de klasse
$builder = new eventBuilder();
// Definieer de admin url
$base_url = get_admin_url() . 'admin.php';
$params = array('page' => basename(__FILE__, ".php"));
// Wat is onze pagina naam?
$page = basename(__FILE__, ".php");
// koppel de admin url en pagina naam samen.
$base_url = add_query_arg($params, $base_url);

// haal de URL data op.
$get_array = $builder->getGetValues();

// Check of er een actie is voer de actie functie uit.
$action = FALSE;
if (!empty($get_array)) {

    if (isset($get_array['action'])) {
        $action = $builder->handleGetAction($get_array);
    }
}

// Haal de post waarden op.
$post_array = $builder->getPostValues();

// Check of submit add is verstuurd, zo ja voer de save functie uit.
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
// Check of de update is verstuurd, zo ja voer de update functie uit.
if (!empty($post_array['update'])) {
    $update = FALSE;
    $result = $builder->update($post_array);
    if ($result) {
        $update = TRUE;
    } else {
        $update = FALSE;
    }
}
// Als de actie delete is, dan voeren we de delete functie uit.
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

<div class="wrap">
    <section id="minimal-statistics">
</div>
<div class="container">
<h4 class="text-uppercase">Event Categories</h4>
    <?php
        // Toon ons de berichten op basis van een true of false betreft de save, update en delete.
    if (isset($add)) {
        echo ($add ? "<p class='mt-5 alert alert-success'>" . $_POST['name'] . " has been added.</p>" : "<p class='mt-5 alert alert-danger'>Category could not be added.</p>");
    }

    if (isset($update)) {
        echo ($update ? "<p class='mt-5 alert alert-success'>" . $_POST['name'] . " has been updated.</p>" : "<p class='mt-5 alert alert-danger'>Category could not be updated.</p>");
    }

    if (isset($del)) {
        echo ($del ? "<p class='mt-5 alert alert-success'>Category has been permanently deleted.</p>" : "<p class='mt-5 alert alert-danger'>Category could not be deleted.</p>");
    }
    // Als de actie niet update is, dan tonen wij het formulier.
    if ($action !== 'update') {
    ?>
    <div class="row mb-5" id="formDiv">
        <div class="col-md-4">
            <form class="row g-3 needs-validation" method="post" action="<?= $base_url; ?>" validate>
                <div class="col-md-12 position-relative">
                    <input type="hidden" name="p" value="<?= $page; ?>">
                    <label for="validationCustom01" class="form-label">Name:</label>
                    <input type="input" class="form-control" maxlength="32" name="name" id="validationCustom01" required>
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
    echo (($action == 'update') ? '<form action="' . $base_url . '" method="post">' : '');
        ?>
            <div class="col-md-8">
                    <?php
                    // als het category aantal kleiner is dan 1, toon ons een warning.
                    if ($builder->getNrOfEventCategories() < 1) {
                    ?>
                        <p class='alert alert-warning text-center'>No event category has been added yet!</p>
                    <?php } else { 
                        if($action !== 'update') {
                        ?>
                        <table class="table table-dark mt-4" id="networkDiv">
                        <thead>
                            <tr>
                                <th width="400">Category</th>
                                <th width="2000">Description</th>
                                <th width="200" colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <?php
                        }
                         // koppel de category lijst.
                        $category = $builder->getEventCategoryList();
                        // voor elk type, maken wij een nieuw object en laaden wij dit in in onze tabel.
                        foreach ($category as $builder_obj) {
                            $params = array('action' => 'update', 'id' => $builder_obj->getId());
                            $upd_link = add_query_arg($params, $base_url);

                            $params = array('action' => 'delete', 'id' => $builder_obj->getId(), 'p' => $page);
                            $del_link = add_query_arg($params, $base_url);
                        ?>

                            <tr>
                                <?php
                                 // als de actie een update is en een ID heeft, tonen wij het update formulier
                                if (($action == 'update') && ($builder_obj->getId() == $get_array['id'])) {
                                ?>
                                    <div class="row">
                                        <div class="col-md-12 position-relative">
                                            <input type="hidden" name="p" value="<?= $page; ?>">
                                            <input type="hidden" name="id" value="<?= $builder_obj->getId(); ?>">
                                            <label for="validationCustom01" class="form-label">Name:</label>
                                            <input type="input" class="form-control" maxlength="32" name="name" id="validationCustom01" required value="<?= $builder_obj->getName(); ?>">
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid type.
                                            </div>
                                            <label for="validationCustom02" class="form-label">Description:</label>
                                            <textarea name="description" rows="10" class="form-control"><?= $builder_obj->getDescription(); ?></textarea>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid description.
                                            </div>
                                        </div>
                                        <div class="mt-3"></div>
                                        <div class="col-12">
                                            <input type="submit" name="update" class="btn btn-success" value="Update">
                                        </div>
                                    </div>
                                <?php } else { 
                                     // als de actie geen update is, dan tonen wij de tabel waarden.
                                     if($action !== 'update') {
                                    ?>
                                    <td width="400"><?= $builder_obj->getName(); ?></td>
                                    <td width="2000"><?= $builder_obj->getDescription(); ?></td>
                                    <?php } 
                                    if ($action !== 'update') {
                                        // Als de actie geen update is, dan tonen wij de update en delete knopjes.
                                    ?>
                                        <td><a href="<?= $upd_link; ?>">
                                                <div class="nftIconAdminCheck" data-toggle="tooltip" data-placement="bottom" title="Edit"></div>
                                            </a></td>
                                        <td><a href="<?= $del_link; ?>" onclick="return confirm('Are you sure you want to permanently delete this network?');">
                                                <div class="nftIconAdminX" data-toggle="tooltip" data-placement="bottom" title="Delete"></div>
                                            </a></td>
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
    </div>
        <?php
        // sluit het update formulier
        echo (($action == 'update') ? '</form>' : '');
        ?>
        </section>
</div>