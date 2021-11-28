<?php
/* @var $this \yii\web\View */

/* @var $content string */

use app\Themes\Basic\widgets\ThemeAsset;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Models\Navigation;
use DuAdmin\Widgets\AutoFixBootstrapColumn;
use DuAdmin\Widgets\DefaultPageFooter;
use DuAdmin\Widgets\LazyLoad;
use DuAdmin\Widgets\Nav;
use DuAdmin\Widgets\Notify;
use DuAdmin\Widgets\SimpleModal;
use Frontend\Assets\AppAsset;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
ThemeAsset::register($this);
Notify::widget();
LazyLoad::widget();
$this->registerJs(AppHelper::getSetting('site.tongji'), View::POS_HEAD);
$this->params['logo'] = AppHelper::getSetting('site.logo');
$siteName = AppHelper::getSetting('site.name', Yii::$app->name);
$slogan = AppHelper::getSetting('site.slogan');
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
    <title><?= Html::encode($this->title . '-' . $siteName  . '-' . $slogan) ?></title>
    <?php
    $this->head();
    echo AppHelper::getSetting('site.googleAdv');
    ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        //首页的样式特殊，导致必须做如下判断
        if (isset($this->params['isIndexPage'])) {
            $navDefClass = 'navbar-hero-affix navbar-hero';
            $affixDefClass = 'navbar-hero';
        } else {
            $affixDefClass = $navDefClass = 'navbar-default';
        }
        $this->registerJs("$('#main-navbar').navbarAffix('" . $affixDefClass . "','navbar-inverse')");
        NavBar::begin([
            'id' => 'main-navbar',
            'brandLabel'   => Yii::t('app', '<i class="fa fa-rocket"></i> ' . $siteName),
            // 'brandImage' => $this->params['logo'],
            'brandUrl'     => [
                '/site/index'
            ],
            'brandOptions' => [
                'title' => $siteName . '-' . $slogan
            ],
            'options'      => [
                'class' => $navDefClass . ' nav-affix'
            ]
        ]);
        $menus = [
            [
                'label' => Yii::t('yii', 'Home'),
                'url'   => [
                    '/site/index'
                ]
            ]
        ];

        $navigations = Navigation::getBootstapNavigation('frontend', true);

        $menus = array_merge($menus, $navigations);
        if (!!AppHelper::getSetting("site.open-login")) {
            if (Yii::$app->user->isGuest) {
                $menus[] = [
                    'label' => Yii::t('app', 'Login'),
                    'url'   => [
                        '/login'
                    ]
                ];
            } else {
                $menus[] = '<li>' . Html::a('<i class="fa fa-user"></i> ' . Yii::$app->user->identity->username, AppHelper::getSetting('site.usercenter-page')) . '</li>';
            }
        }

        echo Nav::widget([
            'options'         => [
                'class' => 'navbar-nav navbar-right text-uppercase'
            ],
            'activateParents' => true,
            'items'           => $menus
        ]);
        NavBar::end();
        AutoFixBootstrapColumn::widget();
        ?>
        <div class="wrap-content">
            <?php
            if (isset($this->params['breadcrumbs'])) :
            ?>
                <div class="container">
                    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ?>
                </div>
            <?php endif; ?>
            <?= $content ?>
        </div>
    </div>

    <?php
    SimpleModal::begin([
        'header'  =>  Yii::t('theme', 'Dialog'),
        'options' => [
            'data-keyboard' => 'false',
            'id'            => 'modal-dialog'
        ]
    ]);
    echo Yii::t('theme', 'Loading ...');
    SimpleModal::end();
    ?>
    <?= DefaultPageFooter::widget() ?>
    <?php $this->endBody() ?>
</body>

</html>
<?php
$this->endPage() ?>