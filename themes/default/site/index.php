<?php
use yii\helpers\Html;
use app\kit\models\Setting;

/* @var $this yii\web\View */
$this->title = '白猿软件-欢迎您';
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Setting::getSettings('site.keywords')
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => Setting::getSettings('site.description')
]);
?>
<div class="front-softs">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="front-soft-card">
					<h2 class="bg-danger">白猿抽奖</h2>
					<div class="soft-body">
						<p>Lucky Lottery 是一款年会抽奖软件，开源免费，简洁大方，在公司的年会中已经多次验证，可靠稳定。</p>
						<?= Html::a('马上获取','https://github.com/dungang/lucky-lottery',['class'=>'btn btn-success', "rel"=>"external", 'target'=>'_blank'])?>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="front-soft-card">
					<h2 class="bg-info">白猿复制</h2>
					<div class="soft-body">
						<p>Baiyuan Copy 是一款万能的突破限制的网页复制浏览器插件，是白领和自媒体必备的神器。可视化，超级方便快捷。</p>
						<p>关键是可以省钱^^</p>
						<?= Html::a('马上获取',['/soft','id'=>1],['class'=>'btn btn-success'])?>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="front-soft-card">
					<h2 class="bg-success">白猿阅读</h2>
					<div class="soft-body">
						<p>Baiyuan Reader 是一款免费的去遮罩的浏览器插件。打开页面的时候自动去除遮罩，有拨开云雾见青天的感觉，去除登录限制</p>
						<?= Html::a('马上获取',['/soft','id'=>2],['class'=>'btn btn-success'])?>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="front-soft-card">
					<h2 class="bg-primary">白猿敏捷管理</h2>
					<div class="soft-body">
						<p>Gee Task 是一个极简的敏捷项目管理系统。一个PMP和ACP的结合的产物，以敏捷为核心却有那么一丁点的传统。</p>
						<p>LESS IS MORE</p>
						<?= Html::a('马上获取','https://github.com/dungang/gee-task',['class'=>'btn btn-success', "rel"=>"external",'target'=>'_blank'])?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
