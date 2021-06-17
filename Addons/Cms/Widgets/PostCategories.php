<?php
namespace Addons\Cms\Widgets;

use Addons\Cms\Models\Category;
use DuAdmin\Helpers\AppHelper;
use yii\helpers\Html;
use yii\base\Widget;

/**
 * 分类列表
 *
 * @author dunga
 *        
 */
class PostCategories extends Widget
{

    public function run()
    {
        $categories = Category::find()->asArray()->all();
        $items = AppHelper::listToTree($categories);
        return $this->renderChilden($items);
    }

    public function renderChilden($items, $pid = 0)
    {
        if ($items) {
            $children = '';
            foreach ($items as $item) {
                $items = '';
                if (isset($item['children']) && is_array($item['children'])) {
                    $items = $this->renderChilden($item['children'], $item['id']);
                }
                $children .= "<li>" . Html::a($item['name'], [
                    '/cms/post/index',
                    'cateId' => $item['id']
                ]) . $items . "</li>";
            }
            return '<ul class="list-items">' . $children . '</ul>';
        }
        return '';
    }
}



