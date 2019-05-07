<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */
use yii\helpers\Html;
use app\kit\widgets\AjaxModalOrNormalPanelContent;

$this->title = '提示信息';
AjaxModalOrNormalPanelContent::begin([
	'intro'=>'操作异常',
]);
?>
<div class="site-error">

	<div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

	<div class="well">
	<p>以上只是温馨提示，可能是您的权限不够。可以联系管理员添加授权.</p>
	<p>如果是错误，系统无法正常运行，请联系开发商.</p>
	</div>

</div>
<?php AjaxModalOrNormalPanelContent::end()?>
