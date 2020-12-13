# DO

java世界的领域对象模型

## 为什么是DO

YII框架给开发者带来了很多方便功能，比如Gii。生成了和业务的Models。

但是我们在相同的模型下，不通场景度数据crud是不同的，业务变化要增加新的字段等，这些都有可能导致模型代码需要修改。

历史久远，不知道当初的配置的原因，就会导致出错。

尽管yii提供了model的场景配置的功能。

但是在本人的实际开发中，发现这样的配置很头疼，甚至出现管理困难。

所有，个人观念，工具生成的代码尽量做到不修改。方便后面的升级，通过工具快速生成

## 在Model之上在包一层,DO

根据业务的形态增加对应的DO对象

控制器尽量跟DO交互

业务的变化可能是小部分，只需要重新生成Model，修改部分DO即可，每个DO我们都知道其目的

## 必须使用DO吗？

如果业务很简单，不然分类的管理，比如地区的管理等，这样的可以不用DO,在绝大多数情况下不会有很大变化。

## DuAdmin的GII支持DO生成

在生成CRUD的时候选择是否生成
