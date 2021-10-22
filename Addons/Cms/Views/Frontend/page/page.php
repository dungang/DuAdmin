<?php

use Addons\Cms\Assets\CmsAsset;
use Addons\Cms\Widgets\AdvBlockWidget;
use DuAdmin\Helpers\AppHelper;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model \Addons\Cms\Models\Page */

AppHelper::seo($this, $model->keywords, $model->description);
$this->title = $model->title . '_' . Yii::t('app', AppHelper::getSetting('site.name'));
$this->params['breadcrumbs'][] = $model->title;
$pagePost = $model->post;
CmsAsset::register($this);
?>
<?= AdvBlockWidget::widget(['nameCode' => 'page', 'urlPath' => \Yii::$app->request->getPathInfo()]) ?>
<div class="container">
    <div class="cms-page">
        <div class="cms-post">
            <div class="page-header">
                <h1><?= Html::encode($pagePost->title) ?></h1>
            </div>
            <div class="cms-post-content">
                <div class="content  text-justify">
                    <?= AppHelper::maxWidthImage($pagePost->content) ?>
                </div>
            </div>

        </div>
    </div>
</div>