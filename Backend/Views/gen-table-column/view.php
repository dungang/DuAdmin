<?php

use yii\widgets\DetailView;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\GenTableColumn */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app_gen_table_column', 'Gen Table Columns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->id;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => Yii::t('da', 'View {0} Detail Info',$model->id),
    'content' => DetailView::widget([
        	'options'=>['class' => 'table table-bordered'],
            'model' => $model,
            'attributes' => [
                'id',
            'tableId',
            'field',
            'comment',
            'tips',
            'enableRequired',
            'enableList',
            'enableQuery',
            'enableSearch',
            'sortable',
            'widgetType',
            'dictType',
            'sort',
            'createdAt:date',
            'updatedAt:date',
            ],
        ])
]);
?>
