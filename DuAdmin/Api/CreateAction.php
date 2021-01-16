<?php

namespace DuAdmin\Api;

use DuAdmin\Core\BizException;
use Yii;
use DuAdmin\Events\CustomerEvent;

class CreateAction extends BaseAction
{

    const EVENT_CREATE_SUCCESS = 'createSuccess';

    public function run()
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = \Yii::createObject($this->modelClass);
        $model->load(\Yii::$app->request->queryParams,'');

        // 执行表单提交
        if ($this->isPost()) {
            // 动态绑定行为
            $model->attachBehaviors($this->modelBehaviors);
            $this->loadFormName = false;
            if (($loaded = $model->load($this->composePostParams($model),'')) && $model->save()) {

                $this->trigger(self::EVENT_CREATE_SUCCESS, new CustomerEvent([
                    'payload' => $model
                ]));
                return $model;
            }

            if ($loaded === false) {
                throw new BizException(Yii::t('da', 'Data fields error'));
            } else if ($model->hasErrors()) {
                throw new BizException(array_values($model->getFirstErrors())[0]);
            }
        }
        throw new BizException('Bad Request');
    }
}
