<?php

use yii\widgets\DetailView;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\MailTemplate */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app_mail_template', 'Mail Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->title;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => Yii::t('da', 'View {0} Detail Info',$model->title),
    'content' => DetailView::widget([
        	'options'=>['class' => 'table table-bordered'],
            'model' => $model,
            'attributes' => [
                'id',
            'code',
            'title',
            'content:ntext',
            'varsInfo',
            'createdAt:date',
            'updatedAt:date',
            ],
        ])
]);
?>
