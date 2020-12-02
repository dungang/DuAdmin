<?php
namespace Backend\Models;

use DuAdmin\Core\BaseModel;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property int $type
 * @property  string $group_name
 * @property string $description
 * @property string $rule_name
 * @property resource $data
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 */
class AuthItem extends BaseModel
{

    /**
     * 角色
     *
     * @var integer
     */
    const TYPE_ROLE = 1;

    /**
     * 权限
     *
     * @var integer
     */
    const TYPE_PERMISSION = 2;


    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%auth_item}}';
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
                    'name',
                    'type'
                ],
                'required'
            ],
            [
                [
                    'type',
                    'created_at',
                    'updated_at'
                ],
                'integer'
            ],
            [
                [
                    'group_name',
                    'description',
                    'data'
                ],
                'string'
            ],
            [
                [
                    'name',
                    'rule_name'
                ],
                'string',
                'max' => 64
            ],
            [
                [
                    'name'
                ],
                'unique'
            ],
            [
                [
                    'rule_name'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => AuthRule::className(),
                'targetAttribute' => [
                    'rule_name' => 'name'
                ]
            ],
            [
                'rule_name','default','value'=>null
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
            'name' => '名称',
            'group_name' => '组',
            'type' => '类型',
            'description' => '介绍',
            'rule_name' => '规则',
            'data' => '数据',
            'created_at' => '添加时间',
            'updated_at' => '更新时间'
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), [
            'item_name' => 'name'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::className(), [
            'name' => 'rule_name'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(AuthItemChild::className(), [
            'parent' => 'name'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(AuthItem::className(), [
            'name' => 'child'
        ])->viaTable(AuthItemChild::tableName(), [
            'parent' => 'name'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(AuthItem::className(), [
            'name' => 'parent'
        ])->viaTable(AuthItemChild::tableName(), [
            'child' => 'name'
        ]);
    }

    public static function allMap($key = 'name', $val = 'description', $where = null, $orderBy = null)
    {
        return parent::allIdToName($key, $val, $where, $orderBy);
    }

    public static function allIdToName($key = 'name', $val = 'description', $where = null, $orderBy = null)
    {
        if ($where == null) {
            $where = [];
        } else {
            $where['type'] = AuthItem::TYPE_ROLE;
        }
        return parent::allIdToName($key, $val, $where, $orderBy);
    }
}
