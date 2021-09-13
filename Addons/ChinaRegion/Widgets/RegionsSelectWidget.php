<?php

namespace Addons\ChinaRegion\Widgets;

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\base\Model;
use yii\bootstrap\Widget;
use Addons\ChinaRegion\Models\ChinaRegion;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class RegionsSelectWidget extends Widget
{

    /**
     * 表单
     *
     * @var ActiveForm
     */
    public $form = null;

    /**
     * 模型
     *
     * @var Model
     */
    public $model = null;

    /**
     * 省份字段
     *
     * @var string
     */
    public $province = 'provinceId';

    /**
     * 城市字段
     * 如果不想出现 该级别的行政区 设置为null
     *
     * @var string
     */
    public $city = 'cityId';

    /**
     * 区县字段
     * 如果不想出现 该级别的行政区 设置为null
     *
     * @var string
     */
    public $district = 'districtId';

    private $dataItems = [];

    public function run()
    {
        $this->view->registerJs($this->registerJs());
        return $this->renderWidget();
    }

    public function renderWidget()
    {
        $items = [];
        $cellWidth = 12;
        // province
        $items[] = $this->getRegionsSubWidget($this->province, $this->city, 0, 2);

        // $city
        if ($this->city !== null) {
            $cellWidth = 6;
            $items[] = $this->getRegionsSubWidget($this->city, $this->district, $this->model[$this->province], 3);
        }

        // district
        if ($this->district !== null) {
            $cellWidth = 4;
            $items[] = $this->getRegionsSubWidget($this->district, null, $this->model[$this->city], 4);
        }

        return Html::tag('div', implode('', array_map(function ($item) use ($cellWidth) {
            return Html::tag('div', $item, [
                'class' => 'col-md-' . $cellWidth
            ]);
        }, $items)), [
            'class' => 'row china-region'
        ]);
    }

    /**
     * 生成下拉选框
     *
     * @param string $field
     * @param string|null $nextField
     * @param number|null $pid
     * @return \yii\bootstrap\ActiveField
     */
    private function getRegionsSubWidget(string $field, $nextField, $pid, $level = 1)
    {
        $options = [];
        if (is_numeric($pid)) {
            if ($this->model[$field] === $pid && $pid > 0) { // 直辖市的问题
                foreach ($this->dataItems as $fieldName => $data) {
                    if (isset($data[$pid]) && $field == $fieldName) {
                        $options = [
                            $pid => $data[$pid]
                        ];
                        break;
                    }
                }
            } else {
                if ($pid > 0 || $level == 2) {
                    $regions = ChinaRegion::find()->where([
                        'pid' => $pid
                    ])
                        ->asArray()
                        ->all();
                    $options = ArrayHelper::map($regions, 'id', 'name');
                }
            }
        }
        // 存储本次请求的数据
        $this->dataItems[$field] = $options;
        return $this->form->field($this->model, $field)->dropDownList($options, [
            'data-target' => $nextField,
            'data-region' => $field,
            'data-level' => $level,
            'prompt' => ''
        ]);
    }

    private function registerJs()
    {
        $fetchOptionsUrl = Url::to([
            '/china-region/regions'
        ]);
        return <<<JS
$('.china-region').each(function(){
    var chinaRegion = $(this);
    chinaRegion.find('select').change(function(){
        var select = $(this);
        var data = select.data();
        chinaRegion.find('[data-region='+data.target+']').each(function(){
            var nextSelect = $(this);
            $.get('$fetchOptionsUrl',{pid:select.val(),level: data.level,current:nextSelect.val()},function(response){
                nextSelect.empty();
                for(var opt of response) {
                    nextSelect.append('<option value="'+opt.id+'" selected="'+opt.selected+'" >'+opt.name+'</option>');
                }
                nextSelect.change();
            });
        });
    });
});
JS;
    }
}
