<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
include MY_EVENT_ORGANISER_PLUGIN_MODEL_SRC_DIR . "/classBuilder.class.php";

$builder = new classBuilder();

$base_url = get_admin_url() . 'admin.php';
$params = array('page' => basename(__FILE__, ".php"));
$base_url = add_query_arg($params, $base_url);

$Shortcodes =   $builder->getKSShortcodes();
$Author     =   $builder->getKSAuthor();
$updateLog  =   $builder->getKSUpdateLog();
$changeLog  =   $builder->getKSChangeLog();
?>
<style>
  .row {
    margin-left 0;
    margin-right: 0;
  }

  .card {
    height: 125px;
  }
</style>

<div class="container-fluid">
  <section id="minimal-statistics">
    <div class="row">
      <div class="col-12 mt-3 mb-1">
        <h4 class="text-uppercase">Dashboard</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-center">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shortcodes">
                    View shortcodes
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-center">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changelog">
                    View changelog
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-center">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateHistory">
                    Update history
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-center">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#author">
                    Author
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-center">
                  <a href="<?=get_site_url().'/my-event-organiser/'?>" class="btn btn-primary">
                    My event organiser
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
</div>

<!-- Shortcodes -->
<div class="modal fade" id="shortcodes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Shortcodes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
        foreach ($Shortcodes as $obj) {
          echo '<strong>' . $obj->getShortName() . '</strong> ' .  $obj->getShortDesc() . '<br><br> ';
        }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Changelog -->
<div class="modal fade" id="changelog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Changelog</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php foreach ($changeLog as $obj) { ?>
          <p><?= $obj->getUpdateDesc(); ?></p>
          <h5><strong><?= $obj->getUpdateVersion(); ?> contains:</strong></h5>
          <ul style="font-size:13px;">
            <?= $obj->getUpdateList(); ?>
          </ul>
          <p><?= $obj->getUpdateFdesc(); ?></p>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Update history -->
<div class="modal fade" id="updateHistory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update History</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <?php foreach ($updateLog as $obj) { ?>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="<?= $obj->getUpdateVersion(); ?>" data-bs-toggle="tab" data-bs-target="#version<?= $obj->getUpdateId(); ?>" type="button" role="tab" aria-controls="<?= $obj->getUpdateVersion(); ?>" aria-selected="true"><?= $obj->getUpdateVersion(); ?></button>
            </li>
          <?php } ?>
        </ul>
        <div class="tab-content" id="myTabContent">
          <?php foreach ($updateLog as $obj) { ?>
            <div class="tab-pane fade" id="version<?= $obj->getUpdateId(); ?>" role="tabpanel" aria-labelledby="test">
              <div class="tab-pane fade show" id="<?= $obj->getUpdateVersion(); ?>" role="tabpanel" aria-labelledby="<?= $obj->getUpdateVersion(); ?>">
                <p><?= $obj->getUpdateDesc(); ?></p>
                <h5><strong><?= $obj->getUpdateVersion(); ?> contains:</strong></h5>
                <ul style="font-size:13px;">
                  <?= $obj->getUpdateList(); ?>
                </ul>
                <p><?= $obj->getUpdateFdesc(); ?></p>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Author name -->
<div class="modal fade" id="author" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Author</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
        foreach ($Author as $obj) {
          echo $obj->getAuthorName() . ' <a href="' . $obj->getAuthorSite() . '" target="_blank">Visit author page</a>';
        }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>