<?php
/* @var $this \yii\web\View */
/* @var $content string */

use DuAdmin\Assets\DuAdminAsset;
use DuAdmin\Widgets\SimpleModal;
use yii\helpers\Html;

DuAdminAsset::register($this);
?>
<?php
$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <base href="<?= \Yii::$app->request->scriptUrl ?>">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('管理后台-' . $this->title) ?></title>
    <?php
    $this->head() ?>
</head>

<body class="skin-green fixed sidebar-mini">
    <?php
    $this->beginBody();
    ?>
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content container-fluid">
                <?= $content; ?>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <?php
    SimpleModal::begin([
        'header' => '对话框',
        'options' => [
            'data-backdrop' => 'static',
            'data-keyboard' => 'false',
            'id' => 'modal-dialog'
        ]
    ]);
    echo "加载中 ... ";
    SimpleModal::end();
    ?>
    <?php
    $this->endBody() ?>
</body>

</html>
<?php
$this->endPage() ?>