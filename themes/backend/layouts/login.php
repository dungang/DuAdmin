<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use app\kit\models\Setting;
use app\kit\assets\BackendAsset;
BackendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= Setting::getSettings('site.tongji')?>
</head>
<body class="hold-transition login-page">
<?php $this->beginBody() ?>
	<?=$content?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
