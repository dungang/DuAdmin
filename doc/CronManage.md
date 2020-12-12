# Cron Manage

## 原理

1 通过一个while不退出的循环检查是否有执行的定时任务。

	通过http请求激活定时任务

2 通过操作系统的crontab执行定时任务
	
	未开发，考虑用yii console来执行
	
## 通过操作系统的crontab执行定时任务

	相对容易实现，但是依赖操作系统的crontab
	