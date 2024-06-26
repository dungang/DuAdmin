<?php
/* @var $this \yii\web\View */

/* @var $content string */

use app\Themes\Basic\widgets\ThemeAsset;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Widgets\LazyLoad;
use DuAdmin\Widgets\SimpleModal;
use Frontend\Assets\AppAsset;
use yii\helpers\Html;
use yii\web\View;

AppAsset::register($this);
ThemeAsset::register($this);
LazyLoad::widget();
$this->registerJs(AppHelper::getSetting('site.tongji'), View::POS_HEAD);
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
    <?php $this->head(); ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?= $content ?>
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
    <?php $this->endBody() ?>
</body>

</html>
<?php
$this->endPage() ?>