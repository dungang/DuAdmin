<?php
use app\kit\models\Setting;
use app\kit\widgets\BackgroundVideo;
use yii\helpers\Url;
use app\kit\helpers\KitHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = '首页';
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Setting::getSettings('site.keywords')
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => Setting::getSettings('site.description')
]);
?>
<div class="site-index">
	<div class="body-content" style="color: white;margin-top:40px;">
		<div class="jumbotron">
			<div class="h1">
				<?=KitHelper::getSetting('site.name') ?><small
					style="vertical-align: top;">&reg;</small>
			</div>
			<p>『 为梦想创业而生 』</p>
			<p>
				豆壳<small style="font-size: 10px; vertical-align: top;">&reg;</small>是一个工具，帮助您以极简的方式记录客户信息。
			</p>
			<p>
				豆壳<small style="font-size: 10px; vertical-align: top;">&reg;</small>是一本账簿，帮助您明晰资金流向和动态，拒绝糊涂账、让每一笔帐都有迹可循。
			</p>
			<p>豆壳<small style="font-size: 10px; vertical-align: top;">&reg;</small>是一种信任，帮助您构建财务信任，让你我他的合作更默契。</p>
		
			<?=Html::a('<i class="fa fa-rocket"></i> 支付宝直接登录',['/oauth/alipay'],['class'=>'btn btn-success'])?>
		</div>
	</div>
</div>
<?php
echo BackgroundVideo::widget([
    'image' => Url::to('http://img.docdada.com/assets/video/office.webp'),
    'video' => Url::to('http://img.docdada.com/assets/video/office480.mp4')
]);
?>