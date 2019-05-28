<?php
use app\backend\widgets\PortalWidget;

$this->title = '看板';
$this->params['breadcrumbs'][] = '看板';
?>
<?= PortalWidget::widget() ?>