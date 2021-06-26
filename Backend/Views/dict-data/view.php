<?php

use yii\widgets\DetailView;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\DictData */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app_dict_data', 'Dict Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->id;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => Yii::t('da', 'View {0} Detail Info',$model->id),
    'content' => DetailView::widget([
        	'options'=>['class' => 'table table-bordered'],
            'model' => $model,
            'attributes' => [
                'id',
            'dictLabel',
            'dictValue',
            'dictType',
            'listCss',
            'isDefault',
            'sort',
            'status',
            'createdAt:date',
            'updatedAt:date',
            ],
        ])
]);
?>
