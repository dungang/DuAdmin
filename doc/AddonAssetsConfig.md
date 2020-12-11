# 插件资源文件配置管理

如果插件有自己的样式，而且需要DuAdmin的wbpack.mix自动编译，需要在目录下添加一个js文件。
文件名称固定位assets.config.js

## assets.config.js 文件内容

```js

exports.assets = {
	src : 'resource/assets/src', //配置资源源码目录
	dist : 'resource/assets/dist', //配置编译目标存储父级目录
	less : [ {
		src : 'less/service-marketing.less', //被编译的less入口文件
		dist : 'css' //编译后存储的目标目录
	} ],
	js : [ {
		src : 'js/service-marketing.js', //被编译的js入口文件
		dist : 'js' //编译后存储的目标目录
	} ]
}

```