<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\AcRouteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '系统路由';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ac-route-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
        <?= Html::a('添加路由', ['create'], ['class' => 'btn btn-success','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
    </p>

    <?=GridView::widget(['dataProvider' => $dataProvider,'filterModel' => $searchModel,'columns' => [['class' => 'yii\grid\SerialColumn'],'name','description:ntext','created_at:date',['class' => 'app\kit\grid\ActionColumn','buttonsOptions' => ['update' => ['data-toggle' => 'modal','data-target' => '#modal-dailog'],'view' => ['data-toggle' => 'modal','data-target' => '#modal-dailog']]]]]);?>
</div>
