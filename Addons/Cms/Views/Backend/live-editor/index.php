<?php

/* @var $this \yii\web\View */

/* @var $content string */

use Backend\Widgets\StartCron;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Widgets\AdminlteNavBar;
use yii\helpers\Html;
use DuAdmin\Assets\DuAdminAsset;

DuAdminAsset::register( $this );
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode( $this->title ) ?></title>
    <?php $this->head() ?>
</head>
<body class="skin-green fixed">
<?php $this->beginBody(); ?>
<div class="wrapper">

    <!-- Main Header -->
    <?php
    AdminlteNavBar::begin( ['showToggleButton' => false] );
    ?>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- Control Sidebar Toggle Button -->
            <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
        </ul>
    </div>
    <?php
    AdminlteNavBar::end();
    ?>
    <div class="du-live-editor">
        <?=$content?>
    </div>
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
            </div>
            <div class="tab-pane" id="control-sidebar-settings-tab">
                test
            </div>
        </div>
    </aside>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
