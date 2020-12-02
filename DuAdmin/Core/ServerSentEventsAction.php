<?php
namespace DuAdmin\Core;


use yii\web\Response;

/**
 *
 * @author dungang
 */
class ServerSentEventsAction extends LongPollAction
{
    
    /**
     * @return Response
     * {@inheritDoc}
     * @see \DuAdmin\Core\LongPollAction::run()
     */
    public function run()
    {
        /* @var $response Response */
        $response = \Yii::createObject([
            'class' => LongPollResponse::className(),
            'format' => 'raw',
            'timeout' => $this->timeoutSeconds,
            'sleepTime' => $this->sleepTimeSeconds,
            'handler' => $this->handler
        ]);
        $response->headers->add('Content-Type','text/event-stream');
        return $response;
    }
}

