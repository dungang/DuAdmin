<?php

namespace app\backend\controllers;

use app\backend\models\Message;
use app\backend\models\SourceMessage;
use app\mmadmin\core\BackendController;
use Yii;

class TranslationController extends BackendController
{

    public function init()
    {
        parent::init();
        $this->userActions = [
            'setting'
        ];
    }

    public function actionSetting($category, $message)
    {
        $attrs = [
            'category' => $category,
            'message' => $message
        ];

        $source_massage = SourceMessage::findOne($attrs);
       
        if (empty($source_massage)) {
            $source_massage = new SourceMessage($attrs);
        }
        if (Yii::$app->request->isPost) {
            SourceMessage::transaction(function ($db) use ($source_massage) {
                if ($source_massage->save()) {
                    Message::deleteAll(['id' => $source_massage->id]);
                    $messages = Yii::$app->request->post('Message', []);
                   
                    $messages = array_map(function ($message) use ($source_massage) {
                        $message['id'] = $source_massage->id;
                        return $message;
                    }, $messages);
                    foreach($messages as $message) {
                        Yii::$app->db->createCommand()->insert(
                            Message::tableName(),
                            $message
                        )->execute();
                    }
                }
            });
        }
        if ($source_massage->id) {
            if (!($messages = Message::findAll([
                'id' => $source_massage->id
            ]))) {
                $messages = [];
            }
        }
        $messages[] = new Message();
        return $this->render('setting', [
            'source_message' => $source_massage,
            'messages' => $messages
        ]);
    }
}
