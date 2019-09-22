<?php

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
	<div class="row">
		<div class="col-md-9" >
    		<div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">最新银行资讯</h3>
              </div>
              <div class="panel-body">
                Panel content
              </div>
            </div>
		</div>
		
		<div class="col-md-3" >
			<div class="panel panel-default">
              <div class="panel-body">
                <strong>无需注册！支付宝登录！</strong>
                <p>请点击导航栏“登录”</p>
              </div>
            </div>
            
            
    		<div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">最新银行资讯</h3>
              </div>
              <div class="panel-body">
                Panel content
              </div>
            </div>
		</div>
		
	</div>
