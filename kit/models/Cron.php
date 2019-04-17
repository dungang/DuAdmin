<?php
namespace app\kit\models;

/**
 * "cron"表的模型类.
 *
 * @property int $id
 * @property string $task 任务
 * @property string $mhdmd 定时
 * @property string $job_script 脚本
 * @property string $param 参数
 * @property string $intro 介绍
 * @property string $token 安全key
 * @property string $error_msg 错误信息
 * @property bool $is_ok 正常
 * @property bool $is_active 激活
 * @property int $run_at 执行时刻
 * @property int $created_at 添加时间
 * @property int $updated_at 更新时间
 */
class Cron extends \app\kit\core\BaseModel
{

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cron}}';
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
                    'mhdmd'
                ],
                'required'
            ],
            [
                [
                    'is_ok',
                    'is_active'
                ],
                'boolean'
            ],
            [
                [
                    'run_at',
                    'created_at',
                    'updated_at'
                ],
                'integer'
            ],
            [
                [
                    'task'
                ],
                'string',
                'max' => 64
            ],
            [
                [
                    'mhdmd'
                ],
                'string',
                'max' => 128
            ],
            [
                [
                    'job_script',
                    'param',
                    'intro',
                    'error_msg'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'token'
                ],
                'string',
                'max' => 32
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
            'task' => '任务',
            'mhdmd' => '定时',
            'job_script' => '脚本',
            'param' => '参数',
            'intro' => '介绍',
            'token' => '安全key',
            'error_msg' => '错误信息',
            'is_ok' => '正常',
            'is_active' => '激活',
            'run_at' => '执行时刻',
            'created_at' => '添加时间',
            'updated_at' => '更新时间'
        ];
    }

    public function attributeHints()
    {
        return [
            'intro' => '任务说明，最简洁的表达任务是干什么，需要特意注意的地方。',
            'mhdmd' => 'linux crontab 表达式, * * * * * * (分 时 天 月 周 年)。',
            'param' => '额外参数，每行表示一个传参，如：a:1。',
            'job_script' => '任务脚本，指的是Yii的路由Id，比如：/backend/crons/index,如果路由的首个字符不是“/”,系统自动添加。'
        ];
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [
            $this,
            'checkToken'
        ]);
        $this->on(self::EVENT_BEFORE_UPDATE, [
            $this,
            'checkToken'
        ]);
    }

    public function checkToken($event)
    {
        if (empty($this->token)) {
            $this->token = \Yii::$app->security->generateRandomString(32);
        }
    }

    /**
     * 更新任务is_ok false
     * @param string $msg 错误信息
     * @return boolean
     */
    public function goBad($msg)
    {
        $this->is_ok = false;
        $this->error_msg = $msg;
        return $this->save(false);
    }

    /**
     *
     * {@inheritdoc}
     * @return CronQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CronQuery(get_called_class());
    }
}
