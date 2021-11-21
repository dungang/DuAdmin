<?php
/* @var \yii\web\View $this  */

use yii\helpers\Url;

$this->title = Yii::t('da', 'Dashboard');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("$('div[data-dashboard-widget]').dashboardWidget('" . Url::to(['/dashboard-widget/render']) . "')");
?>

<div class="row">
    <?php foreach ($counters as $id) : ?>
        <div class="col-lg-3 col-xs-6">
            <div data-dashboard-widget="<?= $id ?>"></div>
        </div>
    <?php endforeach; ?>
</div>
<div class="row">
    <?php foreach ($charts as $id) : ?>
        <div data-dashboard-widget="<?= $id ?>"></div>
    <?php endforeach; ?>
</div>