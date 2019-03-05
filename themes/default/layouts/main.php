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
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name . ' <font class="h6">' . Yii::$app->version . '</font>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top'
        ]
    ]);
    $menus = [
        [
            'label' => '首页',
            'url' => [
                '/site/index'
            ]
        ]
    ];
    if (\Yii::$app->user->isGuest) {
        $menus[] = [
            'label' => '关于',
            'url' => [
                '/site/about'
            ]
        ];
    }
    if (! \Yii::$app->user->isGuest && MiscHelper::isAdmin()) {
        $menus[] = [
            'label' => '软件',
            'url' => [
                '/wf-app/index'
            ]
        ];
        $menus[] = [
            'label'=>'文档',
            'items'=>[
                [
                    'label' => '文档',
                    'url' => [
                        '/doc/index'
                    ]
                ],
                [
                    'label' => '白名单',
                    'url' => [
                        '/doc-white-list/index'
                    ]
                ]
            ]
        ];
        $menus[] = [
            'label' => '运营',
            'items' => [
                [
                    'label' => '资讯',
                    'url' => [
                        '/post/index'
                    ]
                ],
                [
                    'label' => '资讯分类',
                    'url' => [
                        '/post-category/index'
                    ]
                ],
                [
                    'label' => '幻灯片',
                    'url' => [
                        '/flash/index'
                    ]
                ]
            ]
        ];
        $menus[] = [
            'label' => '用户',
            'url' => [
                '/user/index'
            ]
        ];
        $menus[] = [
            'label' => '系统',
            'items' => [
                [
                    'label' => '设置',
                    'url' => [
                        '/setting/index'
                    ]
                ],
                [
                    'label' => '路由',
                    'url' => [
                        '/ac-route/index'
                    ]
                ],
                [
                    'label' => '模块',
                    'url' => [
                        '/app-module/index'
                    ]
                ],
                [
                    'label' => '角色',
                    'url' => [
                        '/auth-role/index'
                    ]
                ],
                [
                    'label' => '权限',
                    'url' => [
                        '/auth-permission/index'
                    ]
                ],
                [
                    'label' => '规则',
                    'url' => [
                        '/auth-rule/index'
                    ]
                ]
            ]
        ];
    }
    if (! \Yii::$app->user->isGuest) {
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
    } else {
        $menus[] = [
            'label' => '登录',
            'url' => [
                '/site/login'
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
        <?=Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []])?>
        <?= Notify::widget() ?>
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

	<footer class="footer">
		<div class="container">
			<p class="pull-left"><?=Setting::getSettings('site.beian')?> &copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

			<p class="pull-right"><?= MiscHelper::powered() ?></p>
		</div>
	</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
