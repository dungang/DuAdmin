# Cron Manage

YII_DEBUG模式下 页面刷新一次只一次。意思是指，没有轮询检查，二十刷新一次执行一次时间检查，调度定时任务。

非YII_DEBUG下，轮询检查时间，调度任务

## 原理

1 通过一个while不退出的循环检查是否有执行的定时任务。

	通过http请求激活定时任务

2 通过操作系统的crontab执行定时任务
	
	未开发，考虑用yii console来执行
	
## 通过操作系统的crontab执行定时任务

	相对容易实现，但是依赖操作系统的crontab
	