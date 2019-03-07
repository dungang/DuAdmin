<?php

use yii\helpers\Html;
use app\kit\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\kit\models\Menu */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
		<h4 class="modal-title"><?= Html::encode($this->title) ?></h4>
</div>
<div class="modal-body">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url:url',
            'is_front:boolean',
            'pid',
            'icon',
            'sort',
        ],
    ]) ?>

</div>
