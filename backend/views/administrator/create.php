<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Backend\Models\Admin */

$this->title = Yii::t('da','Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Administors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=> Yii::t('da','Create {0} Info',Yii::t('backend', 'Administors')),
    'content'=>$this->render('_form', ['model' => $model])
])?>
