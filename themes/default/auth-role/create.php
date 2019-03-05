<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\kit\models\Role */

$this->title = '添加角色';
$this->params['breadcrumbs'][] = [
    'label' => '角色',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title"><?= Html::encode($this->title) ?></h4>
</div>
<div class="modal-body">
    <?=$this->render('_form', ['model' => $model])?>
</div>
