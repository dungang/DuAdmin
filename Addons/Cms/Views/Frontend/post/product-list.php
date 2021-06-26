<?php
use Addons\Cms\Assets\CmsAsset;
use Addons\Cms\Models\Category;
use Addons\Cms\Widgets\AdvBlockWidget;
use yii\bootstrap\Nav;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $searchModel Addons\Cms\Models\Post */
/* @var $category Addons\Cms\Models\Category */
/* @var $subCategories Addons\Cms\Models\Category[] */
/* @var $dataProvider yii\data\ActiveDataProvider */
CmsAsset::register( $this );
$nav_title = Yii::t( 'da_cms', 'All' );
if ( isset( $category ) ) {
  if ( $category->pid == 0 ) {
    $nav_title = $this->title = $category->name;
    $this->params['breadcrumbs'][] = $this->title;
  } else {
    $parent_category = Category::findOne( $category->pid );
    $this->title = $category->name;
    $rootCategory = Yii::t( 'da_cms', $parent_category->name );
    $this->params['breadcrumbs'][] = [
        'label' => $rootCategory,
        'url' => [
            '/cms/post/index',
            'slug' => $parent_category->slug
        ]
    ];
    $nav_title = $rootCategory;
    $this->params['breadcrumbs'][] = $this->title;
  }
} else {
  $category = null;
  $this->params['breadcrumbs'][] = $nav_title;
}
?>
<?=AdvBlockWidget::widget( [ 'nameCode' => 'product-list','urlPath' => \Yii::$app->request->getPathInfo()] )?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title"><?=$nav_title?></h1>
                </div>
                <div class="panel-body">
                    <?=Nav::widget( [ 'activateItems' => false,'items' => array_map( function ( $item ) use ($category ) {if ( $category && $category->slug == $item['slug'] ) {$active = true;} else {$active = false;}return [ 'label' => $item['name'],'active' => $active,'url' => [ '/cms/post/index','slug' => $item['slug']]];}, $subCategories )] )?>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <?php
            echo ListView::widget( [
                'options' => [
                    'class' => 'list-product fix-col-height'
                ],
                'layout' => "{items}\n{pager}",
                'dataProvider' => $dataProvider,
                'itemView' => function ( $model, $key, $index, $widget ) {
                  return $this->render( 'item-product', [
                      'model' => $model
                  ] );
                }
            ] );
            ?>
        </div>
    </div>
</div>