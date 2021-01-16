<?php
namespace DuAdmin\Api;

use BadMethodCallException;
use DuAdmin\Core\BizException;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use DuAdmin\Helpers\AppHelper;

class UpdateAction extends BaseAction
{

    public $newOneOnNotFound = false;

    public function run()
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = $this->findModel($this->newOneOnNotFound);
        $model->load(\Yii::$app->request->queryParams,'');

        if ($this->isPost()) {
            // 动态绑定行为
            $model->attachBehaviors($this->modelBehaviors);
            $this->loadFormName = false;
            if (($loaded = $model->load($this->composePostParams($model),'')) && $model->save()) {
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