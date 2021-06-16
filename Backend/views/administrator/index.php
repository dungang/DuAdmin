<?php
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Widgets\FullSearchBox;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel Backend\Models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t( 'app_admin', 'Admins' );
// $this->params['breadcrumbs'][] = $this->title;
?>
<?php
Pjax::begin( [
    'id' => 'admin-index'
] );
?>
<?php
PanelGridView::begin( [
    'id' => 'admin-list',
    'title' => $this->title,
    'intro' => Yii::t( 'da', '{0} Info Manage', Yii::t( 'app_admin', 'Admins' ) ),
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => '\yii\grid\CheckboxColumn'
        ],
        [
            'attribute' => 'id',
            'format' => 'raw',
            'value' => function ( $model, $key, $index, $column ) {
              return AppHelper::linkButtonWithSimpleModal( $model ['id'], [
                  'view',
                  'id' => $model ['id']
              ] );
            }
        ],
        'username',
        'nickname',
        [
            'label' => Yii::t( 'app_admin', 'Roles' ),
            'format' => 'raw',
            'value' => function ( $model, $key, $index ) {
              $names = [ ];
              if ( $model->isSuper ) {
                $names [] = '<span class="label label-danger">' . Yii::t( 'app_admin', 'Super' ) . '</span>';
              } else {
                foreach ( $model->roles as $role ) {
                  $names [] = '<span class="label label-success">' . $role->name . '</span>';
                }
              }
              return implode( ',', $names );
            }
        ],
        'email:email',
        'mobile',
        'status',
        [
            'class' => 'DuAdmin\Grids\DateTimeColumn',
            'attribute' => 'loginAt'
        ],
        [
            'class' => 'DuAdmin\Grids\DateTimeColumn',
            'attribute' => 'createdAt'
        ],
        [
            'class' => '\DuAdmin\Grids\ActionColumn',
            'template' => '{view} {update} {roles} {delete}',
            'buttons' => [
                'roles' => function ( $url, $model, $key ) {
                  return AppHelper::linkButtonWithSimpleModal( '<i class="fa fa-user"></i> ' . Yii::t( 'app_admin', 'Setting Roles' ), [
                      'assignment-roles',
                      'userId' => $model->id
                  ] );
                }
            ]
          // 'visibleButtons' => [
          // 'roles' => function ($model, $key, $index) {
          // return empty($model->isSuper);
          // }
          // ]
        ]
    ]
] );
?>

<?=FullSearchBox::widget( [ 'action' => [ 'index']] )?>

<?=$this->render( '_search', [ 'model' => $searchModel] );?>

<?=AppHelper::linkButtonWithSimpleModal( '<i class="fa fa-plus"></i> ' . Yii::t( 'da', 'Create' ), [ 'create'], [ 'class' => 'btn btn-primary'] )?>

<?=Html::a( '<i class="fa fa-trash"></i> ' . Yii::t( 'da', 'Delete' ), [ 'delete'], [ 'class' => 'btn btn-danger del-all','data-target' => '#admin-list'] )?>

<?php
PanelGridView::end()?>

<?php
Pjax::end();
?>

