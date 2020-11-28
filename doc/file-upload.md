# 文件上传

系统定义了统一的协议接口

```php
app\mmadmin\storage\IDriver //存储服务的驱动协议接口
app\mmadmin\uploader\ConfigWidget //前端配置协议接口
```

表单小部件

```php
app\mmadmin\widgets\AjaxFileInput //ajax前端直传部件
```

TokenAction
产生token和key（存储的路径）