# Hook


## Hook  定义

必须继承`DuAdmin\Core\Hook`抽象类
一般情况下不用增加属性和方法
Hook基类已经有属性`$payload` 传递数据的属性，`$owner` 触发者

```php
namespance Demo
ServiceActiveHook extends DuAdmin\Core\Hook 
{
}
```

## Hook Handler 定义

必须继承 `DuAdmin\Hooks\Handler` 抽象类

```php
namespace Demo
SmsAssistantProviderActiveHandler extends DuAdmin\Hooks\Handler 
{
	public function process($hook){
		// todo
	}
}
```
## Hook Handler 注册

- 代码注册

```php
Demo\ServiceActiveHook::registerHandler(Demo\SmsAssistantProviderActiveHandler::class)

// 或
DuAdmin\Core\Hook::registerHookHandler(Demo\ServiceActiveHook::class,Demo\SmsAssistantProviderActiveHandler::class)

```

- 配置注册
插件在addon.json文件中配置

```json
{
...
    "hooksMap": {
        "Demo\\ServiceActiveHook": "Demo\\SmsAssistantProviderActiveHandler"
        或者
        "Demo\\ServiceActiveHook": ["Demo\\SmsAssistantProviderActiveHandler"]
    },
...
}
```

## Hook 触发

在业务类中执行如下代码就会触发

```php

ServiceActiveHook::emit($this);

```