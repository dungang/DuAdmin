<?php
use app\mmadmin\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\backend\models\Admin */

$this->title = Yii::t('ma','Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Administors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=> Yii::t('ma','Create {0} Info',Yii::t('backend', 'Administors')),
    'content'=>$this->render('_form', ['model' => $model])
])?>
