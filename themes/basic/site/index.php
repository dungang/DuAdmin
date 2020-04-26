<?php

use app\addons\cms\widgets\ArticleShow;
use app\addons\flash\helpers\FlashHelpers;
use app\addons\flash\models\FeFlash;
use app\addons\required\widgets\RequiredFormShow;
use app\kit\widgets\Swiper;
use yii\helpers\Html;
$this->title = '首页';
?>
<div style="margin-top:-20px;">
    <?= Swiper::widget([
        'items' => FeFlash::find()->orderBy('sort desc')->limit(5)->all(),
        'pagination' => false,
        'slideContentCallback' => function ($item, $index) {
            if ($item['bg_color']) {
                return '<div style="width:100%;height:390px;' . FlashHelpers::gradient_radial() . '"></div>';
            }
            return '<img src="' . $item['pic'] . '" width="100%" style="display:block;max-height:390px;"/>';
        }
    ]) ?>
</div>

<div class="container">
    <h3>公司动态</h3>
    <?= ArticleShow::widget([
        'slug' => 'news',
        'render_callback' => function ($article) {
            return Html::tag('div', $article->title);
        }
    ]) ?>
</div>
<div class="container">
    <h3>给我们留言</h3>
    <div class="row">
        <div class="col-md-5">
        <?= RequiredFormShow::widget() ?>
        </div>
    </div>
</div>