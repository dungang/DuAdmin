<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\backend\models\SourceMessage */

$this->title = Yii::t('da','Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Source Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=> Yii::t('da','Create {0} Info', Yii::t('app', 'Source Messages')),
    'content'=>$this->render('_form', ['model' => $model])
])?>
