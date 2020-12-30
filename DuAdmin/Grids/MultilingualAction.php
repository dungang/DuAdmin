<?php
namespace DuAdmin\Grids;

use yii\grid\Column;
use DuAdmin\Helpers\AppHelper;
use Yii;

/**
 *
 * @author dungang<dungang@126.com>
 * @since 2020-12-30
 */
class MultilingualAction extends Column
{

    public $language = 'zh-CN';

    public $label;

    public $controllerId;

    public $formName;

    public $forignKey;

    public $headerOptions = [
        'width' => '180px'
    ];

    /**
     *
     * {@inheritdoc}
     */
    protected function renderHeaderCellContent()
    {
        return $this->label;
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\grid\Column::renderDataCellContent()
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if ($langauges = $model->languages) {
            $existsLang = null;
            foreach ($langauges as $lang) {
                if (strcmp($lang['language'], $this->language) == 0) {
                    $existsLang = $lang;
                    break;
                }
            }

            if ($existsLang) {
                $buttons = [];
                $params = $existsLang->toArray();
                // 查看
                $params[0] = $this->controllerId . '/view';
                $buttons[] = AppHelper::linkButtonWithBigSimpleModal('<i class="fa fa-eye"></i> ' . Yii::t('da', 'View'), $params, [
                    'class' => 'text-success'
                ]);
                // 更新
                $params[0] = $this->controllerId . '/update';
                $buttons[] = AppHelper::linkButtonWithBigSimpleModal('<i class="fa fa-edit"></i> ' . Yii::t('da', 'Update'), $params, [
                    'class' => 'text-primary'
                ]);
                //删除
                $params[0] = $this->controllerId . '/delete';
                $buttons[] = AppHelper::linkDeleteButton('<i class="fa fa-trash"></i> ' . Yii::t('da', 'Delete'), $params, [
                    'class' => 'text-danger'
                ]);
                return implode(' ', $buttons);
            } else {
                $existsLang = [
                    $this->forignKey => $model->id,
                    'language' => $this->language
                ];
                $route = $this->buildFormNameRoute($existsLang);
                $route[0] = $this->controllerId . '/create';
                return AppHelper::linkButtonWithBigSimpleModal('<i class="fa fa-plus"></i> ' . Yii::t('da', 'Create'), $route);
            }
        }
        return parent::renderDataCellContent($model, $key, $index);
    }

    public function buildFormNameRoute($attrs)
    {
        if ($this->formName) {
            $newKeys = array_map(function ($key) {
                if ($key === 0) {
                    return $key;
                }
                return $this->formName . '[' . $key . ']';
            }, array_keys($attrs));
            return array_combine($newKeys, array_values($attrs));
        }
        return $attrs;
    }

    public static function buildColumns()
    {
        $langs = AppHelper::getSettingAssoc('site.i18n');
        $columns = [];
        foreach ($langs as $lang => $name) {
            $columns[] = [
                'class' => static::class,
                'label' => $name,
                'language' => $lang
            ];
        }
        return $columns;
    }
}

