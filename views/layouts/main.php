<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\kit\assets\AppAsset;
use app\kit\helpers\KitHelper;
use app\kit\models\Menu;
use app\kit\models\Setting;
use app\kit\widgets\LazyLoad;
use app\kit\widgets\Notify;
use app\kit\widgets\SimpleModal;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
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
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandImage' => $this->params['logo'],
                'brandLabel' => KitHelper::getSetting('site.name'),
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse'
                ]
            ]);
            $menus = [];
            if (($frontMenus = Menu::getFrontMenus())) {
                foreach ($frontMenus as $frontMenu) {
                    $menus[] = $frontMenu;
                }
            }
            if (!Yii::$app->user->isGuest) {
                $menus[] = [
                    'label' => Yii::$app->user->identity->nick_name,
                    'items' => [
                        [
                            'label' => '后台',
                            'url' => [
                                '/backend/'
                            ]
                        ],
                        [
                            'label' => '退出',
                            'url' => [
                                '/backend/logout'
                            ],
                            'linkOptions' => [
                                'data-method' => 'post'
                            ]
                        ]
                    ]
                ];
            }
            echo Nav::widget([
                'options' => [
                    'class' => 'navbar-nav navbar-right'
                ],
                'items' => $menus
            ]);
            NavBar::end();
            ?>

            <div class="container">
                <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ?>

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
        </div>

        <footer class="footer bg-primary text-center">
            <div class="container">
                <p><?= Html::a('<i class="fa fa-user"></i> 关于我们', ['/about-us']) ?></p>
                <p>
                    <?= date('Y') ?> &copy; <?= Html::encode(Setting::getSettings('site.company')) ?> 
                </p>
                <p>
                    <a href="tel://<?= Setting::getSettings('site.company.phone') ?>">
                        <i class="fa fa-phone"></i> <?= Setting::getSettings('site.company.phone') ?></a>


                <p><?= Setting::getSettings('site.beian') ?>  </p>
            </div>
        </footer>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
