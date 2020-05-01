<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\frontend\assets\AppAsset;
use app\kit\helpers\KitHelper;
use app\kit\models\Menu;
use app\kit\models\Setting;
use app\kit\widgets\LazyLoad;
use app\kit\widgets\Notify;
use app\kit\widgets\SimpleModal;
use app\themes\basic\widgets\ThemeAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
ThemeAsset::register($this);
Notify::widget();
LazyLoad::widget();
$this->params['logo'] = KitHelper::getSetting('site.logo');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <base href="<?= Yii::$app->request->baseUrl ?>/">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title  . '-' . KitHelper::getSetting('site.name')) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => KitHelper::getSetting('site.name'),
            'brandImage' => $this->params['logo'],
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-default'
            ]
        ]);
        $menus = [
            [
                'label' => '首页',
                'url' => [
                    '/'
                ]
            ]
        ];
        if (($frontMenus = Menu::getFrontMenus())) {
            foreach ($frontMenus as $frontMenu) {
                if ($frontMenu['require_login'] && Yii::$app->user->isGuest) {
                    continue;
                }
                $frontMenu['url'] = KitHelper::normalizeUrl2Route($frontMenu['url']);
                $menus[] = $frontMenu;
            }
        }
        // if (!Yii::$app->user->isGuest) {
        //     $menus[] = [
        //         'label' => Yii::$app->user->identity->nick_name,
        //         'items' => [
        //             [
        //                 'label' => '退出',
        //                 'url' => [
        //                     '/site/logout'
        //                 ],
        //                 'linkOptions' => [
        //                     'data-method' => 'post'
        //                 ]
        //             ]
        //         ]
        //     ];
        // } else {
        //     $menus[] = [
        //         'label' => '登录',
        //         'items' => [
        //             [
        //                 'label' => '支付宝登录',
        //                 'url' => [
        //                     '/oauth/alipay'
        //                 ]
        //             ]
        //         ]
        //     ];
        // }
        echo Nav::widget([
            'options' => [
                'class' => 'navbar-nav navbar-right'
            ],
            'items' => $menus
        ]);
        NavBar::end();
        ?>
        <?php if (isset($this->params['breadcrumbs'])) : ?>
            <div class="container">
                <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ?>
            </div>
        <?php endif; ?>
        <?= $content ?>
        <?php
        SimpleModal::begin([
            'size' => 'modal-lg',
            'header' => '对话框',
            'options' => [
                'id' => 'modal-dailog'
            ]
        ]);
        echo "没有记录";
        SimpleModal::end();
        ?>
    </div>

    <footer class="footer  text-center">
        <div class="container">
            <p><?= Html::a('<i class="fa fa-user"></i>  关于我们', ['/about-us']) ?>
                <?= date('Y') ?> &copy; <?= Html::encode(Setting::getSettings('site.company')) ?>
                <?= Setting::getSettings('site.beian') ?> </p>
        </div>
    </footer>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>