<?php

namespace DuAdmin\Grids;

use Yii;
use yii\db\ActiveRecordInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\Column;
use yii\helpers\ArrayHelper;

class ActionColumn extends Column
{

    /**
     * 附加参数
     */
    public $extParams = [];

    /**
     * 模态框大小：modal-sm modal-lg
     * @var string
     */
    public $modalSize = '';
    /**
     * 指定主键
     * 当一对一关联模型
     * 设置改属性，则会使用关联模型的key作为查询条件
     * 格式['model'=>'模型别名'，'fields'=>['字段','字段']]
     * 比如['model'=>'order','fields'=>['field1','field2']]
     *
     * @var array|null
     */
    public $relationalKey = null;

    /**
     * 外键key
     *
     * @var string
     */
    public $relationForeignKey = '';

    /**
     * 是否支持pjax
     *
     * @var boolean
     */
    public $enablePjax = false;

    /**
     * 默认开启打开模态对话框
     *
     * @var bool
     */
    public $enableOpenModal = true;

    /**
     * 默认模态框选择标识 css selector
     *
     * @var string
     */
    public $modalTarget = "#modal-dialog";

    /**
     * 当没有一个按的时候，显示创建按钮
     *
     * @var string
     */
    public $showCreateButtonOnEmpty = true;

    /**
     *
     * {@inheritdoc}
     */
    public $headerOptions = [
        'class' => 'action-column'
    ];

    public $contentOptions = [
        'class' => 'action-column'
    ];

    /**
     *
     * @var string the ID of the controller that should handle the actions specified here.
     *      If not set, it will use the currently active controller. This property is mainly used by
     *      [[urlCreator]] to create URLs for different actions. The value of this property will be prefixed
     *      to each action name to form the route of the action.
     */
    public $controller;

    /**
     *
     * @var string the template used for composing each cell in the action column.
     *      Tokens enclosed within curly brackets are treated as controller action IDs (also called *button names*
     *      in the context of action column). They will be replaced by the corresponding button rendering callbacks
     *      specified in [[buttons]]. For example, the token `{view}` will be replaced by the result of
     *      the callback `buttons['view']`. If a callback cannot be found, the token will be replaced with an empty string.
     *     
     *      As an example, to only have the view, and update button you can add the ActionColumn to your GridView columns as follows:
     *     
     *      ```php
     *      ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
     *      ```
     *     
     */
    public $template = '{view} {update} {delete}';

    /**
     *
     * @var array button rendering callbacks. The array keys are the button names (without curly brackets),
     *      and the values are the corresponding button rendering callbacks. The callbacks should use the following
     *      signature:
     *     
     *      ```php
     *      function ($url, $model, $key) {
     *      // return the button HTML code
     *      }
     *      ```
     *     
     *      where `$url` is the URL that the column creates for the button, `$model` is the model object
     *      being rendered for the current row, and `$key` is the key of the model in the data provider array.
     *     
     *      You can add further conditions to the button, for example only display it, when the model is
     *      editable (here assuming you have a status field that indicates that):
     *     
     *      ```php
     *      [
     *      'update' => function ($url, $model, $key) {
     *      return $model->status === 'editable' ? Html::a('Update', $url) : '';
     *      },
     *      ],
     *      ```
     */
    public $buttons = [];

    /**
     *
     * @var array visibility conditions for each button. The array keys are the button names (without curly brackets),
     *      and the values are the boolean true/false or the anonymous function. When the button name is not specified in
     *      this array it will be shown by default.
     *      The callbacks must use the following signature:
     *     
     *      ```php
     *      function ($model, $key, $index) {
     *      return $model->status === 'editable';
     *      }
     *      ```
     *     
     *      Or you can pass a boolean value:
     *     
     *      ```php
     *      [
     *      'update' => \Yii::$app->user->can('update'),
     *      ],
     *      ```
     * @since 2.0.7
     */
    public $visibleButtons = [];

    /**
     *
     * @var callable a callback that creates a button URL using the specified model information.
     *      The signature of the callback should be the same as that of [[createUrl()]]
     *      Since 2.0.10 it can accept additional parameter, which refers to the column instance itself:
     *     
     *      ```php
     *      function (string $action, mixed $model, mixed $key, integer $index, ActionColumn $this) {
     *      //return string;
     *      }
     *      ```
     *     
     *      If this property is not set, button URLs will be created using [[createUrl()]].
     */
    public $urlCreator;

    /**
     *
     * @var array html options to be applied to the [[initDefaultButton()|default button]].
     * @since 2.0.4
     */
    public $buttonOptions = [];

    /**
     * 根据不同的button配置otpions
     *
     * @var array
     */
    public $buttonsOptions = [];

    public $tagName = 'td';

    public $enableDropDown = true;

    /**
     *
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->initDefaultButtons();
    }

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye', 'text-primary');
        $this->initDefaultButton('update', 'edit', 'text-success');
        $this->initDefaultButton('delete', 'trash', 'text-danger', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post'
        ]);
    }

    /**
     * Initializes the default button rendering callback for single button.
     *
     * @param string $name
     *            Button name as it's written in template
     * @param string $iconName
     *            The part of Bootstrap glyphicon class that makes it unique
     * @param array $additionalOptions
     *            Array of additional options
     * @since 2.0.11
     */
    protected function initDefaultButton($name, $iconName, $btnClass, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = $this->getButtonCallback($name, $iconName, $btnClass, $additionalOptions);
        }
    }

    protected function getButtonCallback($name, $iconName, $btnClass, $additionalOptions = [])
    {
        return function ($url, $model, $key) use ($name, $iconName, $btnClass, $additionalOptions) {

            switch ($name) {
                case 'create':
                    $title = Yii::t('yii', 'Create');
                    break;
                case 'view':
                    $title = Yii::t('yii', 'View');
                    break;
                case 'update':
                    $title = Yii::t('yii', 'Update');
                    break;
                case 'delete':
                    $title = Yii::t('yii', 'Delete');
                    break;
                default:
                    $title = ucfirst($name);
            }
            $buttonOptions = isset($this->buttonsOptions[$name]) ? $this->buttonsOptions[$name] : [];
            $defaultOptions = [
                'title' => $title,
                'aria-label' => $title,
                'data-pjax' => $this->enablePjax,
                'class' => $btnClass
            ];
            if ($this->enableOpenModal && $name != 'delete') {
                $defaultOptions['data-toggle'] = 'modal';
                $defaultOptions['data-modal-size'] = $this->modalSize;
                $defaultOptions['data-target'] = $this->modalTarget;
            }

            $options = array_merge($defaultOptions, $additionalOptions, $this->buttonOptions, $buttonOptions);
            $icon = Html::tag('span', '', [
                'class' => "fa fa-$iconName"
            ]) . $title;
            return Html::a($icon, $url, $options);
        };
    }

    public function getRoute($action)
    {
        return $this->controller ? $this->controller . '/' . $action : $action;
    }

    /**
     * Creates a URL for the given action and model.
     * This method is called for each button and each row.
     *
     * @param string $action
     *            the button name (or action ID)
     * @param \yii\db\ActiveRecordInterface $model
     *            the data model
     * @param mixed $key
     *            the key associated with the data model
     * @param int $index
     *            the current row index
     *            
     * @return string the created URL
     */
    public function createUrl($action, $model, $key, $index)
    {
        if (is_callable($this->urlCreator)) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index, $this);
        }

        if (is_array($this->relationalKey) && $model instanceof ActiveRecordInterface) {

            foreach ($this->relationalKey['fields'] as $field) {
                if ($model[$this->relationalKey['model']]) {
                    $params[$field] = $model[$this->relationalKey['model']][$field];
                }
            }
        } else {
            $params = $this->builderParams($model, $key);
        }

        // 如果没有参数则表示不显示按钮
        if (empty($params)) {
            return null;
        }

        $params[0] = $this->getRoute($action);

        //return Url::toRoute($params);
        if(!empty($this->extParams)) {
            $params = ArrayHelper::merge($params,$this->extParams);
        }
        return $params;
    }

    protected function builderParams($model, $key)
    {
        if (is_array($key)) {
            $params = $key;
        } else if ($this->grid && $this->grid->dataProvider->key) {
            // 设置了特定的key的情况
            $params = [
                $this->grid->dataProvider->key => $key
            ];
        } else if ($model instanceof ActiveRecordInterface) {
            // 复合主键的情况
            $keyNames = $model->primaryKey();
            $params = [];
            foreach ($keyNames as $keyName) {
                $params[$keyName] = $model[$keyName];
            }
        } else {
            // 默认用id
            $params = [
                'id' => (string) $key
            ];
        }
        return $params;
    }

    /**
     * Renders a data cell.
     * @param mixed $model the data model being rendered
     * @param mixed $key the key associated with the data model
     * @param int $index the zero-based index of the data item among the item array returned by [[GridView::dataProvider]].
     * @return string the rendering result
     */
    public function renderDataCell($model, $key, $index)
    {
        if ($this->contentOptions instanceof \Closure) {
            $options = call_user_func($this->contentOptions, $model, $key, $index, $this);
        } else {
            $options = $this->contentOptions;
        }

        return Html::tag($this->tagName, $this->renderDataCellContent($model, $key, $index), $options);
    }


    /**
     *
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->enableDropDown) {
            // 使用下拉列表的形式展示编辑相关的按钮
            return $this->renderDataCellContentWidthDropDown($model, $key, $index);
        } else {
            return $this->renderDataCellContentLine($model, $key, $index);
        }
    }

    /**
     *
     * {@inheritdoc}
     */
    protected function renderDataCellContentLine($model, $key, $index)
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];

            if (isset($this->visibleButtons[$name])) {
                $isVisible = $this->visibleButtons[$name] instanceof \Closure ? call_user_func($this->visibleButtons[$name], $model, $key, $index) : $this->visibleButtons[$name];
            } else {
                $isVisible = true;
            }

            if ($isVisible && isset($this->buttons[$name])) {
                $url = $this->createUrl($name, $model, $key, $index);
                return call_user_func($this->buttons[$name], $url, $model, $key);
            }

            return '';
        }, $this->template);
    }

    protected function renderDataCellContentWidthDropDown($model, $key, $index)
    {
        $matches = [];
        $li_btns = "";
        if (preg_match_all('/\\{([\w\-\/]+)\\}/', $this->template, $matches)) {
            foreach ($matches[1] as $name) {
                if (isset($this->visibleButtons[$name])) {
                    $isVisible = $this->visibleButtons[$name] instanceof \Closure ? call_user_func($this->visibleButtons[$name], $model, $key, $index) : $this->visibleButtons[$name];
                } else {
                    $isVisible = true;
                }

                if ($isVisible && isset($this->buttons[$name])) {

                    if ($url = $this->createUrl($name, $model, $key, $index)) {
                        $li_btns .= '<li>' . call_user_func($this->buttons[$name], $url, $model, $key) . '</li>';
                    }
                }
            }
        }
        // 显示创建按钮
        if (empty($li_btns) && $this->showCreateButtonOnEmpty) {
            $callback = $this->getButtonCallback('create', 'plus', 'text-success');
            $action = $this->getRoute($this->wrapperAction('create', $model));
            $paramName = ucfirst($this->relationalKey['model']) . '[' . $this->relationForeignKey . ']';

            $url = Url::to([
                $action,
                $paramName => $model['id']
            ]);

            $li_btns .= '<li>' . call_user_func($callback, $url, $model, $key) . '</li>';
        }
        if ($li_btns) {
            return $this->renderDropDown($li_btns);
        }
        return '';
    }

    protected function renderDropDown($menus)
    {
        return <<<DD
<div class="dropdown">
  <button class="btn btn-link btn-xs dropdown-toggle" type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
    <span class="fa fa-ellipsis-v"></span>
  </button>
  <ul class="dropdown-menu dropdown-menu-right">
  $menus
  </ul>
</div>
DD;
    }
}
