<?php

use Addons\Cms\Assets\CmsAsset;
use Addons\Cms\Helpers\CmsHelpers;
use DuAdmin\Helpers\AppHelper;

/* @var $this yii\web\View */
/* @var $model \Addons\Cms\Models\Page */
AppHelper::seo($this,$model->keywords,$model->description);
$this->title = $model->title . '_' . Yii::t('app', AppHelper::getSetting('site.name'));
$this->params['breadcrumbs'] = null;
CmsAsset::register($this);
$pagePost = $model->post;
CmsAsset::register($this);
if ($pagePost->content) {
    CmsHelpers::registerBlockAssets($pagePost->content);
    $pagePost->content = CmsHelpers::parseDynamicPageBlock($pagePost->content);
}
?>

<div class="live-content">
    <?= $pagePost->content  ?>
</div>
