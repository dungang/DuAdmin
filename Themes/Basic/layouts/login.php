<?php
/* @var $this \yii\web\View */
/* @var $content string */
use DuAdmin\Helpers\AppHelper;
use Frontend\Assets\AppAsset;
use app\Themes\Basic\widgets\ThemeAsset;
use yii\helpers\Html;
use yii\web\View;
AppAsset::register( $this );
ThemeAsset::register( $this );
?>
<?php
$this->registerJs( AppHelper::getSetting( 'site.tongji' ), View::PH_HEAD );
$this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
<meta charset="<?=Yii::$app->charset?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?=Html::csrfMetaTags()?>
    <title><?=Html::encode( $this->title )?></title>
    <?php
    $this->head()?>
</head>
<body class="hold-transition login-page">
<?php
$this->beginBody()?>
	<?=$content?>
<?php
$this->endBody()?>
</body>
</html>
<?php
$this->endPage()?>
