<?php

use yii\widgets\DetailView;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\GenTable */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app_gen_table', 'Gen Tables'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->id;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => Yii::t('da', 'View {0} Detail Info',$model->id),
    'content' => DetailView::widget([
        	'options'=>['class' => 'table table-bordered'],
            'model' => $model,
            'attributes' => [
                'id',
            'tableName',
            'tableComment',
            'modelNamespace',
            'modelName',
            'modelBaseName',
            'activeQueryBaseName',
            'dbConnectionId',
            'enableSearchModel',
            'enableI18n',
            'backendControllerNamespace',
            'frontendControllerNamespace',
            'apiControllerNamespace',
            'backendControllerBase',
            'frontendControllerBase',
            'apiControllerBase',
            'controllerName',
            'backendViewPath',
            'frontendViewPath',
            'backendListView',
            'frontendistView',
            'backendActions',
            'frontendActions',
            'modalDailogSize',
            'enableUserData',
            'enablePjax',
            'createdAt:date',
            'updatedAt:date',
            ],
        ])
]);
?>
