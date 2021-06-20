<?php
use Addons\Cms\Portals\PageCounterPortal;
use Addons\Cms\Portals\PostCounterPortal;
use Backend\Portals\SystemInfoPortal;
use app\backend\portals\AdminCounterPortal;
/* @var $this \yii\web\View */
$this->title = '看板';
$this->params['breadcrumbs'][] = '看板';
?>

<div class="row">
<?=AdminCounterPortal::widget()?>
<?=PageCounterPortal::widget()?>
<?=PostCounterPortal::widget()?>
</div>
<div class="row">
<?=SystemInfoPortal::widget()?>
</div>