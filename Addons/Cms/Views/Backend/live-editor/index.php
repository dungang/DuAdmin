<?php

/* @var $this \yii\web\View */

/* @var $content string */

use Addons\Cms\Assets\LiveEditorAsset;
use Addons\Cms\Models\PageBlock;
use Addons\Cms\Models\PagePost;
use DuAdmin\Assets\DuAdminAsset;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Widgets\AdminlteNavBar;
use DuAdmin\Widgets\AjaxFileInput;
use yii\bootstrap\Modal;
use yii\helpers\Html;

DuAdminAsset::register( $this );
LiveEditorAsset::register( $this );

/** @var PagePost $model * */
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
<body>
<?php $this->beginBody(); ?>
<div class="skin-green">
    <!-- Main Header -->
    <?php
    AdminlteNavBar::begin( ['showToggleButton' => false] );
    ?>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- Control Sidebar Toggle Button -->
            <li>
                <a id="du-live-editor-save-button"><i class="fa fa-save"></i> 保存</a>
            </li>
        </ul>
    </div>
    <?php
    AdminlteNavBar::end();
    ?>
    <div class="du-live-editor" data-page-id="<?= $model->pageId ?>" data-language="<?= $model->language ?>">

        <div class="du-live-workspace">
            <aside class="control-sidebar-dark du-live-editor-elements-control">
                <!-- Create the tabs -->
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li class="active">
                        <a href="#control-sidebar-home-tab" data-toggle="tab">
                            <i class="fa fa-columns"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#control-sidebar-settings-tab" data-toggle="tab">
                            <i class="fa fa-image"></i>
                        </a>
                    </li>
                </ul>
                <div class="tab-content du-live-blocks">
                    <!-- Home tab content -->
                    <?php $layouts = PageBlock::findAll( ['type' => 'layout'] ) ?>
                    <div class="tab-pane active" id="control-sidebar-home-tab">
                        <ul class="list-group">
                            <?php foreach ( $layouts as $layout ) : ?>
                                <li class="list-group-item du-list-group-item du-layout" data-id="<?= $layout->id ?>">
                                    <?= Html::img( ['/cms/live-editor/load-icon', 'id' => $layout->id], ['class' => 'lazyload', 'width' => '100%'] ) ?>
                                    <div class="name"><?= $layout->name ?></div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="tab-pane" id="control-sidebar-settings-tab">
                        <?php $elements = PageBlock::findAll( ['type' => 'element'] ) ?>
                        <div class="tab-pane" id="control-sidebar-home-tab">
                            <ul class="list-group">
                                <?php foreach ( $elements as $element ) : ?>
                                    <li class="list-group-item du-list-group-item du-element"
                                        data-id="<?= $element->id ?>">
                                        <?= Html::img( ['/cms/live-editor/load-icon', 'id' => $element->id], ['class' => 'lazyload', 'width' => '100%'] ) ?>
                                        <div class="name"><?= $element->name ?></div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="du-live-page">
                <?= Html::tag( "iframe", "", [
                        'id' => 'live-iframe',
                    "src" => AppHelper::createFrontendUrl( ["/" . $model->page->slug,'live'=>true] )
                ] ) ?>
            </div>
        </div>

        <?php Modal::begin( [
            'id'     => 'du-live-image-setting-dialog',
            'header' => '设置图片',
            'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary confirm-btn">确定</button>'
        ] );
        echo AjaxFileInput::widget( ['name'     => 'file',
                                     'clip'     => 'false',
                                     'compress' => 'flase',
                                     'options'  => [
                                         'class' => 'form-control'
                                     ]] );
        Modal::end(); ?>

        

    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
