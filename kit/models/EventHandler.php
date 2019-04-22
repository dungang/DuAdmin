<?php
namespace app\kit\models;

use yii\db\Query;
use yii\base\Component;

/**
 * "event_handler"表的模型类.
 *
 * @property int $id
 * @property int $event_id 事件
 * @property string $name 名称
 * @property bool $is_active 激活
 * @property string $handler 处理器
 * @property int $sort 处理顺序
 * @property string $intro 说明
 */
class EventHandler extends \app\kit\core\BaseModel
{

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%event_handler}}';
    }

    /**
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'event_id',
                    'sort'
                ],
                'integer'
            ],
            [
                [
                    'name',
                    'handler'
                ],
                'required'
            ],
            [
                [
                    'is_active'
                ],
                'boolean'
            ],
            [
                [
                    'name'
                ],
                'string',
                'max' => 64
            ],
            [
                [
                    'handler'
                ],
                'string',
                'max' => 128
            ],
            [
                [
                    'intro'
                ],
                'string',
                'max' => 255
            ]
        ];
    }

    /**
     *
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => '事件',
            'name' => '名称',
            'is_active' => '激活',
            'handler' => '处理器',
            'sort' => '处理顺序',
            'intro' => '说明'
        ];
    }

    /**
     *
     * {@inheritdoc}
     * @return EventHandlerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EventHandlerQuery(get_called_class());
    }

    const CacheKey = 'sys.event.handlers';

    public function behaviors()
    {
        $b = parent::behaviors();
        $b['cleanCache'] = [
            'class' => 'app\kit\behaviors\ReCacheBehavior',
            'cache_keys' => [
                self::CacheKey => [
                    __CLASS__,
                    'getActiveEventHandlersData'
                ]
            ]
        ];
        return $b;
    }

    public static function getActiveEventHandlersData()
    {
        $levelHandlers = [];
        if ($handlers = (new Query())->select('e.event,e.level,h.handler')
            ->from([
            'e' => Event::tableName(),
            'h' => self::tableName()
        ])
            ->where('e.id = h.event_id and h.is_active = 1')
            ->orderBy('h.sort asc')
            ->all()) {
            foreach ($handlers as $handler) {
                if (empty($levelHandlers[$handler['level']]))
                    $levelHandlers[$handler['level']] = [];
                $levelHandlers[$handler['level']][] = $handler;
            }
        }
        return $levelHandlers;
    }

    public static function getCacheActiveEventHandlers($level = null)
    {
        $handlers = \Yii::$app->cache->getOrSet(self::CacheKey, function () {
            return self::getActiveEventHandlersData();
        });
        if ($level !== null && isset($handlers[$level])) {
            return $handlers[$level];
        }
        return [];
    }

    /**
     * 给目标对象组成对应的实际处理器
     *
     * @param Component $target
     * @param string $level
     */
    public static function registerLevel($target, $level)
    {
        if ($handlers = EventHandler::getCacheActiveEventHandlers($level)) {
            foreach ($handlers as $handler) {
                $target->on($handler['event'], [
                    \Yii::createObject($handler['handler']),
                    'process'
                ]);
            }
        }
    }
}
