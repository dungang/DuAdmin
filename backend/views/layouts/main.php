<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use DuAdmin\Widgets\Notify;
use DuAdmin\Widgets\SimpleModal;
use DuAdmin\Helpers\MAHelper;
use DuAdmin\Models\Setting;
use DuAdmin\Models\Menu;
use DuAdmin\Assets\BackendAsset;
use DuAdmin\Widgets\AdminlteNavBar;
use DuAdmin\Widgets\AdminlteSideBar;
use DuAdmin\Widgets\AdminlteSideBarMenu;
use Backend\Widgets\Startcron;
use DuAdmin\Widgets\FloatThead;

BackendAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <base href="<?= \Yii::$app->request->scriptUrl ?>">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('管理后台-' . $this->title) ?></title>
    <?php $this->head() ?>
</head>
<?php
/*
     * BODY TAG OPTIONS:
     * =================
     * Apply one or more of the following classes to get the
     * desired effect
     * |---------------------------------------------------------|
     * | SKINS | skin-blue |
     * | | skin-black |
     * | | skin-purple |
     * | | skin-yellow |
     * | | skin-red |
     * | | skin-green |
     * |---------------------------------------------------------|
     * |LAYOUT OPTIONS | fixed |
     * | | layout-boxed |
     * | | layout-top-nav |
     * | | sidebar-collapse |
     * | | sidebar-mini |
     * |---------------------------------------------------------|
     */
?>

<body class="skin-green fixed sidebar-mini">
    <?php
    $this->beginBody();
    $user = \Yii::$app->user->getIdentity();
    if (empty($user->avatar)) {
        $user->avatar = 'images/user2-160x160.jpg';
    }
    ?>
    <div class="wrapper">

        <!-- Main Header -->
        <?php AdminlteNavBar::begin([]); ?>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button --> <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <?= MAHelper::img($user->avatar, ['class' => 'user-image', 'width' => 160, 'height' => 160]) ?>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"><?= $user->nickname ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <?= MAHelper::img($user->avatar, ['class' => 'img-circle', 'width' => 160, 'height' => 160]) ?>
                            <p>
                                <?= $user->nickname ?>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a('个人信息', ['/profile'], ['data-toggle' => 'modal', 'data-target' => '#modal-dailog', 'class' => 'btn btn-default btn-flat']) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a('退出', ['/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <?php AdminlteNavBar::end(); ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php AdminlteSideBar::begin([]); ?>

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <?= MAHelper::img($user->avatar, ['class' => 'img-circle', 'width' => '45px', 'height' => '45px']) ?>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->nickname ?></p>
                <!-- Status -->
                <i class="fa fa-circle text-success"></i> 在线
            </div>
        </div>
        <?= AdminlteSideBarMenu::widget(['headerLabel' => '导航', 'items' => Menu::getBackMenus()]) ?>

        <?php AdminlteSideBar::end(); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?= Html::encode($this->title) ?>
                </h1>
                <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ?>
            </section>

            <!-- Main content -->
            <section class="content container-fluid">
                <?php
                /*
                * --------------------------
                * | Your Page Content Here |
                * --------------------------
                */
                echo $content;
                ?>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">DUAdmin</div>
            <!-- Default to the left -->
            <strong>Copyright &copy; <?= date('Y') ?> <a href="#"><?= Html::encode(Setting::getSettings('site.name')) ?></a>.
            </strong> All rights reserved.
        </footer>
    </div>
    <?php
    SimpleModal::begin([
        'header' => '对话框',
        'options' => [
            'data-backdrop' => 'static',
            'data-keyboard' => 'false',
            'id' => 'modal-dailog'
        ]
    ]);
    echo "加载中 ... ";
    SimpleModal::end();
    ?>
    <?= Notify::widget() ?>
    <?= FloatThead::widget() ?>
    <?= StartCron::widget() ?>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>