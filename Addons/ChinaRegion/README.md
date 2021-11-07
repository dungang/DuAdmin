# 中国行政区插件

数据来源《2020年10月中华人民共和国县以上行政区划代码》

http://www.mca.gov.cn/article/sj/xzqh/2020/2020/2020112010001.html

- 复制页面的内容
- 保存为text文件每行的头部不能有空格，不用特殊处理，处理了可能不能识别

## 如何使用

```php
$form = ActiveForm::begin();
echo RegionsSelectWidget::widget([
        'form'=>$form,
        'model' => $model,
        'district' => null,
    ]);

echo RegionsSelectWidget::widget([
        'showInline' => false,
        'singleCssClass' => 'col-xs-6',
        'model' => $model,
        'form' => $form
    ]);
ActiveForm::end();
```