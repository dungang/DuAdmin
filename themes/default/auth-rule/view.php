<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\kit\models\AuthRule */

$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => '规则',
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

    <?=DetailView::widget(['model' => $model,'attributes' => ['name','data','created_at','updated_at']])?>

</div>
