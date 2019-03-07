<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $generators \app\generators\Generator[] */
/* @var $content string */

$generators = Yii::$app->controller->module->generators;
$this->title = '生成器-高效快捷代码生成器';
?>
<div class="default-index">
    <div class="page-header">
        <h1>生成器 <small>这个工具可以像变魔术一样为你生成出漂亮的规范的代码</small></h1>
    </div>

    <p class="lead">开始使用如下的生成器吧，想必一定像一场快乐的旅行。</p>

    <div class="row">
        <?php foreach ($generators as $id => $generator): ?>
        <div class="generator col-lg-4">
            <h3><?= Html::encode($generator->getName()) ?></h3>
            <p><?= $generator->getDescription() ?></p>
            <p><?= Html::a('开始使用 &raquo;', ['default/view', 'id' => $id], ['class' => 'btn btn-default']) ?></p>
        </div>
        <?php endforeach; ?>
    </div>

</div>
