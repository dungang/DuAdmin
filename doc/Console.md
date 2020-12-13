# 控制台

## 数据迁移

添加插件的数据迁移

	php yii addon-migrate/create AddonName 

执行所有包括插件的数据迁移

	php yii dua-migrate/fresh
	
添加系统的数据迁移

	php yii migrate/create
	
	
## 生成模拟数据

加载到数据库
	
	php yii dua-fixture/load --addonName=AddonName "*"