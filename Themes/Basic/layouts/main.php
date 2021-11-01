<?php
/* @var $this \yii\web\View */

/* @var $content string */

use Addons\Cms\Widgets\CmsPageFooter;
use app\Themes\Basic\widgets\ThemeAsset;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Models\Navigation;
use DuAdmin\Widgets\AutoFixBootstrapColumn;
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
$company = AppHelper::getSetting('site.company');
$siteName = Yii::t('app', AppHelper::getSetting('site.name', Yii::$app->name));
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
    <title><?= Html::encode($this->title . '-' . $siteName . '-' . $company) ?></title>
    <?php
    $this->head();
    echo AppHelper::getSetting('site.googleAdv');
    ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel'   => Yii::t('app', '<i class="fa fa-rocket"></i> ' . $siteName),
            // 'brandImage' => $this->params['logo'],
            'brandUrl'     => [
                '/site/index'
            ],
            'brandOptions' => [
                'title' => $siteName . '-' . $company
            ],
            'options'      => [
                'class' => 'navbar-default nav-affix'
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
        if (Yii::$app->user->isGuest) {
            $menus[] = [
                'label' => Yii::t('app', 'Login'),
                'url'   => [
                    '/login'
                ]
            ];
        } else {
            $menus[] = '<li>' . Html::beginForm([
                '/site/logout'
            ], 'post') . Html::submitButton(Yii::t('app', 'Logout') . ' ( ' . Yii::$app->user->identity->username . ' ) ', [
                'class' => 'btn btn-link logout'
            ]) . Html::endForm() . '</li>';
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
        <?php
        if (isset($this->params['breadcrumbs'])) :
        ?>
            <div class="container">
                <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ?>
            </div>
        <?php endif; ?>
        <?= $content ?>
    </div>

    <?php
    SimpleModal::begin([
        'header'  => '对话框',
        'options' => [
            'data-keyboard' => 'false',
            'id'            => 'modal-dialog'
        ]
    ]);
    echo "加载中 ... ";
    SimpleModal::end();
    ?>
    <?= CmsPageFooter::widget() ?>
    <?php $this->endBody() ?>
</body>

</html>
<?php
$this->endPage() ?>