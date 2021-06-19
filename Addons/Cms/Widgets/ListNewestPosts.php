<?php

namespace Addons\Cms\Widgets;

use Addons\Cms\Models\Category;
use Addons\Cms\Models\Post;
use yii\base\Widget;

/**
 * 显示最新的文章列表
 *
 * @author dunga
 *
 */
class ListNewestPosts extends Widget {

  public $viewName = 'list-newest-posts';

  public $cateSlug;

  public $size = 10;

  public function run() {

    $query = Post::find()->where( [
        'isPublished' => 1
    ] );
    $category = null;
    if ( $this->cateSlug ) {
      $category = Category::findOne( [
          'slug' => $this->cateSlug
      ] );
      if ( $category ) {
        $query->where( [
            'cateId' => $category->id
        ] );
      }
    }
    $posts = $query->limit( $this->size )->orderBy( 'createdAt desc' )->all();
    return $this->render( $this->viewName, [
        'models' => $posts,
        'category' => $category,
        'cateSlug' => $this->cateSlug
    ] );

  }
}

