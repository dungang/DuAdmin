<?php
use Addons\Cms\Models\Flash;
use DuAdmin\Widgets\SlickCarousel;
use Frontend\Forms\ContactForm;
use yii\helpers\FileHelper;
/* @var yii\web\View  $this */
$this->title = Yii::t( 'theme', 'Home' );
$files = FileHelper::findFiles( Yii::getAlias( '@app/public/images/screen/' ), [
    'recursive' => false ] );
if ( $files ) {
  $files = array_map( function ( $file ) {
    return new Flash( [
        'pic' => 'images/screen/' . basename( $file ) ] );
  }, $files );
} else {
  $files = [ ];
}
?>
<div class="dua bg-primary dua-banner">
	<div class="container">
		<div class="jumbotron text-center">
			<h1>Hello DUAdmin!</h1>
			<p>For My Best Friends.</p>
		</div>
		<div class="demo-swiper">
    		<div class="show-swiper">
    		<?php
      echo SlickCarousel::widget( [
          'className' => 'demo-screen',
          'slideClassName' => 'demo-slide',
          'viewName' => $this->theme->basePath . '/site/slick-carousel',
          'items' => $files ] )?>
    		</div>
		</div>
	</div>
</div>
<div class="block-bar">
<h1 class="text-center"><?=Yii::t( 'app', 'Features' )?></h1>
<div class="container">
    <div class="row fix-col-height">
        <div class="col-sm-3 col-md-3">
            <div class="feature">
                <i class="glyphicon glyphicon-wrench"></i>
                <h3>代码生成更强大</h3>
                <p>约定大于配置，在Yii2 generator的基础上增加和修改了更加强大的代码生成功能，包括高级搜索支持时间段查询，自动生成模糊查询所有字符串类型的字段。</p>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="feature">
                <i class="glyphicon glyphicon-flash"></i>
                <h3>不仅只是PJAX</h3>
                <p>在DuAdmin的管理后台，完美结合了pjax和bootstrap的modal,表单提交成功后可以支持局部刷新列表</p>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="feature">
                <i class="glyphicon glyphicon-list"></i>
                <h3>更丰富的列表显示</h3>
                <p>
                    包装了Adminlte Panel的GridView和TreeGridView,TreeSortableList.更加优美的ActionColumn小部件。
                </p>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="feature">
                <i class="glyphicon glyphicon-user"></i>
                <h3>RBAC权限管理更直观</h3>
                <p>基于YII2-RBAC，在不丢失强大功能的基因的基础上，更加合理的规划权限、角色和规则的组织结构，呈现了最直观的管理方式</p>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="feature">
                <i class="glyphicon glyphicon-globe"></i>
                <h3>国际化</h3>
                <p>更加清晰的国际化消息分类文件规划，分类文件全部有DuAdmin自动关联，延迟加载。更加诱人的是使用generator根据表的注解生成翻译。多语言管理组件的支持，可以快速开发多语言的内容，比如：CMS
                </p>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="feature">
                <i class="glyphicon glyphicon-blackboard"></i>
                <h3>API开发</h3>
                <p>DuAdmin在设计之初就考虑了3个入口，管理后台，会员后台，API的功能</p>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="feature">
                <i class="glyphicon glyphicon-gift"></i>
                <h3>模块化插件</h3>
                <p>插件是在module的基础上开发，解决插件前后端的控制器不被交叉范围的问题。插件可以有自己的vendor，只需要简单的配置即可完成插件的配置功能。</p>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="feature">
                <i class="glyphicon glyphicon-transfer"></i>
                <h3>丰富的数据迁移</h3>
                <p>一键管理前端后端包括插件的数据迁移文件。交互的数据迁移管理，最大化减少开发者输入负载的别名和路径。</p>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="feature">
                <i class="glyphicon glyphicon-bullhorn"></i>
                <h3>Hook机制</h3>
                <p>支持前后端，插件的hook注册，也可以实现异步（开发中）</p>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="feature">
                <i class="glyphicon glyphicon-road"></i>
                <h3>Webpack.mix.js</h3>
                <p>DuAdmin做了定制开发，可以在前后端，包括插件内部编辑js、less源码，而不用在一个src下开发所有功能的资源文件。大大提高了代码管理效率。每个插件都应该有自己的资源文件，而不是跟总项目混在一起。
                </p>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="feature">
                <i class="glyphicon glyphicon-home"></i>
                <h3>可定制前端首页</h3>
                <p>简单的管理前端首页的内容，通过PageBlock管理，前端，插件提供的块，动态生成前端首页。功能比较基础，但是满足一般的场景。</p>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="feature">
                <i class="glyphicon glyphicon-thumbs-up"></i>
                <h3>POWERED BY YII2</h3>
                <p>Yii is a high-performance PHP framework best for developing Web 2.0 applications.</p>
            </div>
        </div>
    </div>
</div>
</div>
<div class="block-bar-gray">
  <?=$this->render( '@Frontend/Views/site/contactForm', [ 'model' => new ContactForm() ] );?>
</div>
