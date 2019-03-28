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
use app\kit\helpers\KitHelper;
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
<body>
<?php $this->beginBody() ?>

<div class="wrap">
		    <?php
    NavBar::begin([
        'brandLabel' => Setting::getSettings('site.name'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-inverse'
        ]
    ]);
 
    NavBar::end();
    ?>
		<div class="front-breadcrumb">
			<div class="container">
        <?=Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []])?>
		</div>
		</div>
		<div class="front-content">
			<div class="container">
        	<?= $content ?>
        	</div>
		</div>
	</div>
	<footer class="footer">
		<div class="container">
			<p class="pull-left"><?=Setting::getSettings('site.beian')?>  &copy; <?= Html::encode(Setting::getSettings('site.name')) ?> <?= date('Y') ?></p>

			<p class="pull-right">蜗牛CMS</p>
		</div>
	</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>