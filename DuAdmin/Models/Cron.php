<?php

namespace DuAdmin\Models;

use Yii;

/**
 * "cron"表的模型类.
 *
 * @property int $id
 * @property string $task 任务
 * @property string $mhdmd 定时
 * @property string $jobScript 脚本
 * @property string $param 参数
 * @property string $intro 介绍
 * @property string $token 安全key
 * @property string $errorMsg 错误信息
 * @property bool $isOk 正常
 * @property bool $isActive 激活
 * @property string $app 归属应用
 * @property int $runAt 执行时刻
 * @property int $createdAt 添加时间
 * @property int $updatedAt 更新时间
 */
class Cron extends \DuAdmin\Core\BaseModel
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
                    'mhdmd',
                    'app'
                ],
                'required'
            ],
            [
                [
                    'isOk',
                    'isActive'
                ],
                'boolean'
            ],
            [
                [
                    'runAt',
                    'createdAt',
                    'updatedAt'
                ],
                'safe'
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
                    'mhdmd',
                    'app'
                ],
                'string',
                'max' => 128
            ],
            [
                [
                    'jobScript',
                    'param',
                    'intro',
                    'errorMsg'
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
            'id' =>  Yii::t('app_setting', 'ID'),
            'task' =>  Yii::t('app_setting', 'Task'),
            'mhdmd' =>  Yii::t('app_setting', 'Mhdmd'),
            'jobScript' =>  Yii::t('app_setting', 'Job Script'),
            'param' =>  Yii::t('app_setting', 'Param'),
            'intro' =>  Yii::t('app_setting', 'Intro'),
            'token' =>  Yii::t('app_setting', 'Token'),
            'error_msg' =>  Yii::t('app_setting', 'Error Msg'),
            'isOk' =>  Yii::t('app_setting', 'Is Ok'),
            'isActive' =>  Yii::t('app_setting', 'Is Active'),
            'app' => Yii::t('app_setting', 'App'),
            'runAt' =>  Yii::t('app_setting', 'Run At'),
            'createdAt' =>  Yii::t('app_setting', 'Created At'),
            'updatedAt' =>  Yii::t('app_setting', 'Updated At'),
        ];
    }

    public function attributeHints()
    {
        return [
            'intro' => '任务说明，最简洁的表达任务是干什么，需要特意注意的地方。',
            'mhdmd' => 'linux crontab 表达式, * * * * * (分 时 天 月 周)。',
            'param' => '额外参数，每行表示一个传参，如：a:1。',
            'jobScript' => '任务脚本，指的是Yii的路由Id，比如：/backend/crons/index,如果路由的首个字符不是“/”,系统自动添加。'
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
     * 更新任务isOk false
     * @param string $msg 错误信息
     * @return boolean
     */
    public function goBad($msg)
    {
        $this->isOk = false;
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
