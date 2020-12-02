<?php
namespace DuAdmin\Core;

use Yii;

/**
 * 批量删除，待完善，目前还不支持查找参数的设置
 * 直接通过多个id批量上传存在安全隐患。不能保证有固定的查找参数
 * 问题:单主键是多个字段的联合主键的时候，还没处理好
 *
 * @author dungang
 */
class DeleteModelsAction extends BaseAction
{

    public $redirect = null;

    public function init()
    {
        if (null === $this->redirect) {
            $this->redirect = \Yii::$app->request->referrer;
        }
    }

    public function run()
    {
        /* @var $model \yii\db\ActiveRecord */
        /* @var $models \yii\db\ActiveRecord[] */
        $models = $this->findModels();

        try {
            Yii::$app->db->transaction(function ($db) use ($models) {
                foreach ($models as $model) {
                    // 动态绑定行为
                    $model->attachBehaviors($this->modelBehaviors);
                    $model->delete();
                }
            });
        } catch (\Exception $e) {
            Yii::warning($e->getMessage());
            return $this->controller->redirectOnFail($this->redirect);
        }
        return $this->controller->redirectOnSuccess($this->redirect);
    }
}

