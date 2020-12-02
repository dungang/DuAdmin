# 文件上传

系统定义了统一的协议接口

- 支持本地存储和第三方OSS类存储
- 第三方OSS支持本地中转和前端直传

## 存储提供者必须都实现如下接口

```php
DuAdmin\storage\IDriver //存储服务的驱动协议接口
DuAdmin\uploader\ConfigWidget //前端配置协议工厂类
```
## 本地存储
系统默认实现了IDriver接口

```php
DuAdmin\storage\LocalDriver
```

## 表单小部件

```php
DuAdmin\widgets\AjaxFileInput //ajax前端直传部件
```

## TokenAction
产生token和key（存储的路径）