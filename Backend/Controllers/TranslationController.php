<?php

namespace Backend\Controllers;

use Backend\Models\Message;
use Backend\Models\SourceMessage;
use DuAdmin\Core\BackendController;
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
            return SourceMessage::transaction(function ($db) use ($source_massage) {
                if ($source_massage->save()) {
                    Message::deleteAll(['id' => $source_massage->id]);
                    $messages = Yii::$app->request->post('Message', []);

                    $messages = array_map(function ($message) use ($source_massage) {
                        $message['id'] = $source_massage->id;
                        return $message;
                    }, $messages);
                    foreach ($messages as $message) {
                        if(!empty($message['translation'])) {
                            Yii::$app->db->createCommand()->insert(
                                Message::tableName(),
                                $message
                            )->execute();
                        }
                        
                    }
                    return $this->redirectOnSuccess(Yii::$app->request->referrer);
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
