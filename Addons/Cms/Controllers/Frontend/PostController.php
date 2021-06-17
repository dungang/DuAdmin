<?php

namespace Addons\Cms\Controllers\Frontend;

use Addons\Cms\Models\Category;
use Addons\Cms\Models\Post;
use Addons\Cms\Models\PostSearch;
use DuAdmin\Core\BaseController;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Post 模型的控制器
 * PostController 实现了常规的增删查改等行为
 */
class PostController extends BaseController {

  /**
   * 列出所有的 Post 模型.
   *
   * @return mixed
   */
  public function actionIndex() {

    // 默认视图模板
    $viewName = 'index';
    $searchModel = new PostSearch();
    $dataProvider = $searchModel->search( Yii::$app->request->queryParams );
    // 获取分类相关的信息
    $category = null;
    // 子分类
    $subCategories = null;
    // 查询 文章的 分类
    $categoryIds = null;
    if ( $slug = Yii::$app->request->get( 'slug' ) ) {
      // 如果是分类的slug
      $category = Category::findOne( [
          'slug' => $slug
      ] );
    } else if ( $cateId = Yii::$app->request->get( 'cateId' ) ) {
      // 如果是分类的Id
      $category = Category::findOne( $cateId );
    }
    // 如果分类是存在的
    if ( $category ) {
      // 根据分类设置的视图显示列表
      $viewName = $category->template . '-list';
      $pid = $category->id;
      if ( $category->pid > 0 ) {
        $pid = $category->pid;
      }
      // 查找子分类
      $subCategories = Category::find()->where( [
          'pid' => $pid
      ] )->orderBy( 'sort' )->asArray()->indexBy( 'id' )->all();
      if ( $category->pid > 0 ) {
        $categoryIds = $category->id;
      } else {
        $categoryIds = array_keys( $subCategories );
      }
    }
    $dataProvider->query->where( [
        'isPublished' => 1,
        'categoryId' => $categoryIds
    ] )->with( 'category' );
    return $this->render( $viewName, [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'category' => $category,
        'subCategories' => $subCategories
    ] );

  }

  /**
   * 显示单个的 Post 模型数据.
   *
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionShow( $id ) {

    $post = $this->findModel( $id );
    $category = $post->category;
    if ( $category->template ) {
      $viewName = $category->template;
    } else {
      $viewName = 'post';
    }
    return $this->render( $viewName, [
        'model' => $post,
        'category' => $category
    ] );

  }

  /**
   * 根据模型的主键Id查询 Post 模型.
   * 如果模型没有找到, 404 HTTP 异常将会抛出.
   *
   * @param integer $id
   * @return Post the loaded model
   * @throws NotFoundHttpException 如果模型没查询到
   */
  protected function findModel( $id ) {

    if ( ($model = Post::findOne( [
        'id' => $id,
        'isPublished' => 1
    ] )) !== null ) {
      return $model;
    }
    throw new NotFoundHttpException( Yii::t( 'app', 'The requested page does not exist.' ) );

  }
}
