<?php
use yii\helpers\Html;
use DuAdmin\Widgets\SelectBox;
/* @var $widget  SelectBox */
$id = $widget->options['id'];
?>
<?=Html::beginTag('table',$widget->options)?>
    <tr>
        <td width="45%"><input id="<?=$id?>-source-search" type="text" class="form-control" placeholder="查询"></td>
        <td width="10%"></td>
        <td width="45%"><input id="<?=$id?>-target-search" type="text" class="form-control" placeholder="查询"></td>
    </tr>
    <tr>
        <td>
            <?= Html::beginTag('select',['id'=>$id .'-source','class'=>'form-control','multiple'=>true,'size'=>$widget->boxOptions['size']?:6]);?>
                <?php foreach($widget->sourceItems as $key => $val){
                    if (isset($widget->targetItems[$key])) continue;
                    echo "<option value='$key'>$key - $val</option>";
                }?>
            <?= Html::endTag('select')?>
        </td>
        <td>
            <button type="button" id="<?=$id?>-btn-yes" class="btn btn-sm btn-block btn-primary"><i class="fa fa-arrow-right"></i></button>
            <button type="button" id="<?=$id?>-btn-no" class="btn btn-sm btn-block  btn-danger"><i class="fa fa-arrow-left"></i></button>
        </td>
        <td>
            <?=$target?>
        </td>
    </tr>
<?=Html::endTag('table')?>