<?php
use app\addons\cms\widgets\ArticleShow;
use app\addons\flash\widgets\Swiper;
use app\addons\required\widgets\RequiredFormShow;
use yii\helpers\Html;

$this->title = '首页';
?>
<div style="margin-top:-20px;">
    <?= Swiper::widget() ?>
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