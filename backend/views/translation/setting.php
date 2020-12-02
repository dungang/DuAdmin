<?php

use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this \yii\web\View */

$this->title = Yii::t('ma','Setting Translation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('ma','Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=> Yii::t('ma','Translate message'),
    'content'=>$this->render('_form', [
        'source_message' => $source_message,
        'messages' => $messages
        ])
])
?>