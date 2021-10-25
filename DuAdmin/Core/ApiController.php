<?php

namespace DuAdmin\Core;

use Yii;
use yii\base\Arrayable;
use yii\base\Model;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ApiController extends Controller
{
    public $hiddenFields;

    /**
     * 不接受验证的actionId
     */
    public $authExceptActions = [];

    /**
     * {@inheritdoc}
     */
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
            'verbFilter' => [
                'class' => VerbFilter::class,
                'actions' => $this->verbs(),
            ],
            'authenticator' => [
                'class' => HttpBearerAuth::class,
                'except' => $this->authExceptActions
            ]
        ];
    }

    /**
     * 保存模型
     * @return mixed
     * @throws BizException
     */
    public function saveModel($model) {
        if ( ($loaded = $model->load( Yii::$app->request->post() )) && $model->save() ) {
            return $model->id;
        }
        if ( $loaded === false ) {
            throw new BizException( Yii::t( 'da', 'Data fields error' ) );
        } else if ( $model->hasErrors() ) {
            throw new BizException( array_values( $model->getFirstErrors() )[ 0 ] );
        } else {
            throw new BizException( Yii::t( 'da', 'Save fail' ) );
        }
    }

    /**
     * @param $dataProvider
     * @return array
     */
    public function pageData($dataProvider) {
        return [
            'items' => $dataProvider->getModels(),
            'totalCount' => $dataProvider->pagination->totalCount,
            'pageCount' => $dataProvider->pagination->getPageCount(),
            'currentPage' => $dataProvider->pagination->getPage() + 1,
            'perPage' => $dataProvider->pagination->getPageSize(),
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        return $this->serializeData($result);
    }

    /**
     * Declares the allowed HTTP verbs.
     * Please refer to [[VerbFilter::actions]] on how to declare the allowed verbs.
     * @return array the allowed HTTP verbs.
     */
    protected function verbs()
    {
        return [];
    }

    /**
     * Serializes the specified data.
     * The default implementation will create a serializer based on the configuration given by [[serializer]].
     * It then uses the serializer to serialize the given data.
     * @param mixed $data the data to be serialized
     * @return mixed the serialized data.
     */
    protected function serializeData($data)
    {
        if ($data instanceof Model && $data->hasErrors()) {
            return $this->serializeModelErrors($data);
        } elseif ($data instanceof \JsonSerializable) {
            return $data->jsonSerialize();
        } elseif ($data instanceof Arrayable) {
            return $data->toArray();
        } elseif (is_array($data)) {
            $serializedArray = [];
            foreach ($data as $key => $value) {
                $serializedArray[$key] = $this->serializeData($value);
            }
            return $serializedArray;
        }

        return $data;
    }
}
