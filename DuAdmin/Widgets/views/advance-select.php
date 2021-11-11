<?php

use DuAdmin\Helpers\AppHelper;
use yii\bootstrap\Html;

?>
<div role="advance-select">
    <div class="clearfix">
        <div class="pull-left" style="margin-right:15px;"><?= AppHelper::linkButtonWithSimpleModal("<i class='fa fa-plus'></i> 添加", ['create'], ['class' => 'btn btn-success']) ?></div>
        <div class="pull-left"><?= Html::dropDownList('name', null, ['是', '否'], ['class' => 'form-control']) ?></div>
    </div>
    <?= $input ?>
    <!-- <div id="cr-owner-index" data-pjax-container=""  data-pjax-timeout="1000">
    </div> -->
    <table class="table table-bordered">
        <tr>
            <?php foreach ($fields as $field => $name) : ?>
                <th field="<?= $field ?>"><?= $name ?></th>
            <?php endforeach; ?>
            <th>操作</th>
        </tr>
    </table>
</div>