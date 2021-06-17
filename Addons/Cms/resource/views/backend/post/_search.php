<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use DuAdmin\Widgets\DatePicker;
use Backend\Models\Admin;
use Addons\Cms\Models\Category;

/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\PostSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

\yii\bootstrap\Modal::begin([
    'id' => 'post-search-modal',
    'header' => '高级搜索',
    'toggleButton' => [
        'label' => '<i class="fa fa-search"></i> 高级搜索',
        'class' => 'btn btn-warning'
    ]
]);
?>
<div class="post-search">

    <?php

    $form = ActiveForm::begin([
        'action' => [
            'index'
        ],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'onsubmit' => "\$('#post-search-modal').modal('hide')"
        ]
    ]);
    ?>
    <div class="row">

        <?= '<div class="col-xs-6">' . $form->field($model, 'userId')->dropDownList(Admin::allIdToName('id', 'nickname'), ['prompt' => '']) . '</div>' ?>

        <?= '<div class="col-xs-6">' . $form->field($model, 'cateId')->dropDownList(Category::allIdToName(), ['prompt' => '']) . '</div>' ?>

        <?= '<div class="col-xs-6">' . $form->field($model, 'createdAt')->widget(DatePicker::class, ['multidate' => 2]) . '</div>' ?>

        <?= '<div class="col-xs-6">' . $form->field($model, 'updatedAt')->widget(DatePicker::class, ['multidate' => 2]) . '</div>' ?>

        <?= '<div class="col-xs-6">' . $form->field($model, 'title') . '</div>' ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i> ' .  Yii::t('da', 'Search'), ['class' => 'btn btn-warning']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php Modal::end(); ?>