<?php

/* @var $this \yii\web\View */
/* @var $content string */
use app\kit\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\kit\widgets\Notify;
use app\kit\widgets\SimpleModal;
use app\kit\helpers\MiscHelper;
use app\kit\models\Setting;
use app\kit\models\Menu;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= Setting::getSettings('site.tongji')?>
</head>
<body class="skin-green-light">
<?php $this->beginBody() ?>

<div class="wrapper">
		<header class="main-header"> 
		    <?php
                NavBar::begin([
                    'brandLabel' => Yii::$app->name . ' <font class="h6">' . Yii::$app->version . '</font>',
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => [
                        'class' => 'navbar-default'
                    ]
                ]);
                $menus = [];
                $menus[] = [
                    'label' => '首页',
                    'url' => [
                        '/site/index'
                    ]
                ];
                
                if($frontMenus = Menu::getFrontMenus()){
                    foreach($frontMenus as $frontMenu) {
                        $menus[] = $frontMenu;
                    }
                }
            
                $menus[] = [
                    'label' => '关于',
                    'url' => [
                        '/site/about'
                    ]
                ];
            
                if (! \Yii::$app->user->isGuest) {
                    $menus[] = [
                        'label' => '软件',
                        'url' => [
                            '/wf-app/index'
                        ]
                    ];
                    $menus[] = [
                        'label' => Yii::$app->user->identity->nick_name,
                        'items' => [
                            [
                                'label' => '个人信息',
                                'url' => [
                                    '/user/profile'
                                ],
                                'linkOptions' => [
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modal-dailog'
                                ]
                            ],
                            [
                                'label' => '退出',
                                'url' => [
                                    '/site/logout'
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
		</header>

		<div class="front-breadcrumb">
			<div class="container">
        <?=Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []])?>
        <?= Notify::widget() ?>
		</div>
		</div>
		<div class="front-content">
        <?= $content ?>
    </div>
	</div>
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
	<footer class="footer">
		<div class="container">
			<p class="pull-left"><?=Setting::getSettings('site.beian')?>  &copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

			<p class="pull-right"><?= MiscHelper::powered() ?></p>
		</div>
	</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
