<?php
/* @var $this \yii\web\View */
/* @var $content string */

use Backend\Widgets\StartCron;
use DuAdmin\Assets\DuAdminAsset;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Models\Menu;
use DuAdmin\Models\Setting;
use DuAdmin\Widgets\AdminlteNavBar;
use DuAdmin\Widgets\AdminlteSideBar;
use DuAdmin\Widgets\AdminlteSideBarMenu;
use DuAdmin\Widgets\Notify;
use DuAdmin\Widgets\SimpleModal;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

DuAdminAsset::register($this);
?>
<?php
$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <base href="<?= \Yii::$app->request->scriptUrl ?>">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('管理后台-' . $this->title) ?></title>
    <?php
    $this->head() ?>
</head>

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
        <?php
        AdminlteNavBar::begin([
            'logoLargeLabel' => getenv('APP_NAME'),
            'logoMiniLabel' => getenv('APP_NAME_MINI'),
        ]);
        ?>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button --> <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <?= AppHelper::img($user->avatar, ['class' => 'user-image', 'width' => 160, 'height' => 160]) ?>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"><?= $user->nickname ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <?= AppHelper::img($user->avatar, ['class' => 'img-circle', 'width' => 160, 'height' => 160]) ?>
                            <p>
                                <?= $user->nickname ?>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a('个人信息', ['/profile'], ['data-toggle' => 'modal', 'data-target' => '#modal-dialog', 'class' => 'btn btn-default btn-flat']) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a('退出', ['/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <?php
        AdminlteNavBar::end();
        ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php
        AdminlteSideBar::begin([]);
        ?>

        <!-- Sidebar user panel (optional) -->
        <?= AdminlteSideBarMenu::widget(['headerLabel' => '主导航', 'enableHeader' => true, 'items' => Menu::getBackMenus()]) ?>
        <?php
        AdminlteSideBar::end();
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?= Html::encode($this->title) ?>
                    <?= !empty($this->params['subTitle']) ? Html::tag('small', $this->params['subTitle']) : '' ?>
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
            'id' => 'modal-dialog'
        ]
    ]);
    echo "加载中 ... ";
    SimpleModal::end();
    ?>
    <?= Notify::widget() ?>
    <?php
    // FloatThead::widget() 
    ?>
    <?= StartCron::widget() ?>
    <?php
    $this->endBody() ?>
</body>

</html>
<?php
$this->endPage() ?>