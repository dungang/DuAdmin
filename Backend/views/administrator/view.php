<?php

use yii\widgets\DetailView;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Backend\Models\Admin */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Administors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->username;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => Yii::t('da', 'View {0} Detail Info',$model->username),
    'content' => DetailView::widget([
        	'options'=>['class' => 'table table-bordered'],
            'model' => $model,
            'attributes' => [
                'id',
            'username',
            'nick_name',
            'avatar',
            'email:email',
            'mobile',
            'status',
            'login_failure',
            'login_time:datetime',
            'login_ip',
            'created_at:datetime',
            'updated_at:datetime',
            'is_del',
            ],
        ])
]);
?>
