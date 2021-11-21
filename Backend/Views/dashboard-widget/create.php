<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\DashboardWidget */

$this->title = Yii::t('da','Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app_dashboard_widget', 'Dashboard Widgets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=> Yii::t('da','Create {0} Info',Yii::t('app_dashboard_widget', 'Dashboard Widgets')),
    'content'=>$this->render('_form', ['model' => $model,'action'=>['create']])
])?>
