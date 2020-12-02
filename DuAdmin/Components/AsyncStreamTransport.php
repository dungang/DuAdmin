<?php

namespace DuAdmin\Components;

use Yii;
use Exception;
use yii\httpclient\Transport;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

/**
 * 作用于发送定时任务的请求
 * \stream_set_blocking($stream, false);
 * 此类不处理响应的结果，所以不读取响应的结果
 * 因此，放弃读取数据流 stream_get_contents($stream);
 * @author dungang
 */
class AsyncStreamTransport extends Transport
{

    /**
     *
     * {@inheritdoc}
     */
    public function send($request)
    {
        $request->beforeSend();

        $request->prepare();

        $url = $request->getFullUrl();
        $method = strtoupper($request->getMethod());

        $contextOptions = [
            'http' => [
                'method' => $method,
                'ignore_errors' => true
            ],
            'ssl' => [
                'verify_peer' => false
            ]
        ];

        $content = $request->getContent();
        if ($content !== null) {
            $contextOptions['http']['content'] = $content;
        }
        $headers = $request->composeHeaderLines();
        $contextOptions['http']['header'] = $headers;

        $contextOptions = ArrayHelper::merge($contextOptions, $this->composeContextOptions($request->getOptions()));

        $token = $request->client->createRequestLogToken($method, $url, $headers, $content);
        Yii::info($token, __METHOD__);
        Yii::beginProfile($token, __METHOD__);

        try {
            $context = stream_context_create($contextOptions);
            $stream = fopen($url, 'rb', false, $context);
            //设置位了非堵塞的流
            \stream_set_blocking($stream, false);
            $responseContent = ''; // stream_get_contents($stream);
            // see http://php.net/manual/en/reserved.variables.httpresponseheader.php
            $responseHeaders = $http_response_header;
            //\var_dump($responseHeaders);die;
            fclose($stream);
        } catch (\Exception $e) {
            \Yii::endProfile($token, __METHOD__);
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

        Yii::endProfile($token, __METHOD__);

        $response = $request->client->createResponse($responseContent, $responseHeaders);

        $request->afterSend($response);

        return $response;
    }

    /**
     * Composes stream context options from raw request options.
     *
     * @param array $options
     *            raw request options.
     * @return array stream context options.
     */
    private function composeContextOptions(array $options)
    {
        $contextOptions = [];
        foreach ($options as $key => $value) {
            $section = 'http';
            if (strpos($key, 'ssl') === 0) {
                $section = 'ssl';
                $key = substr($key, 3);
            }
            $key = Inflector::underscore($key);
            $contextOptions[$section][$key] = $value;
        }
        return $contextOptions;
    }
}
