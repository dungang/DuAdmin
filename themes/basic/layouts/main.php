<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\frontend\assets\AppAsset;
use app\mmadmin\helpers\MAHelper;
use app\mmadmin\models\Menu;
use app\mmadmin\models\Setting;
use app\mmadmin\widgets\LazyLoad;
use app\mmadmin\widgets\Notify;
use app\mmadmin\widgets\SimpleModal;
use app\themes\basic\widgets\ThemeAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
ThemeAsset::register($this);
Notify::widget();
LazyLoad::widget();
$this->params['logo'] = MAHelper::getSetting('site.logo');
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
    <title><?= Html::encode($this->title . '-' . Yii::t('app',MAHelper::getSetting('site.name'))) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::t('app',MAHelper::getSetting('site.name',Yii::$app->name)),
            //'brandImage' => $this->params['logo'],
            'brandUrl' => ['/site/index'],
            'options' => [
                'class' => 'navbar-inverse nav-affix',
            ]
        ]);
        $menus = [
            [
                'label' => Yii::t('yii','Home'),
                'url' => [
                    '/site/index'
                ]
            ]
        ];
        if (($frontMenus = Menu::getFrontMenus())) {
            foreach ($frontMenus as $frontMenu) {
                if ($frontMenu['require_login'] && Yii::$app->user->isGuest) {
                    continue;
                }
                $frontMenu['url'] = MAHelper::normalizeUrl2Route($frontMenu['url']);
                $menus[] = $frontMenu;
            }
        }
        echo Nav::widget([
            'options' => [
                'class' => 'navbar-nav navbar-right text-uppercase'
            ],
            'activateParents'=>true,
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
            'header' => Yii::t('ma','Dailog'),
            'options' => [
                'id' => 'modal-dailog'
            ]
        ]);
        echo Yii::t('ma','No Data');
        SimpleModal::end();
        ?>
    </div>

    <footer class="footer  text-center">
        <div class="container">
            <p><?= Html::a('<i class="fa fa-user"></i>  ' . Yii::t('theme','About Us'), ['/about-us']) ?>
                <?= date('Y') ?> &copy; <?= Html::encode(Yii::t('app',Setting::getSettings('site.company'))) ?>
                <?= Setting::getSettings('site.beian') ?> </p>
        </div>
    </footer>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>