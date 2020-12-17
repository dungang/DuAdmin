<?php
return [
    // 注册项目的别名
    // 没有注册 DuAdmin目录，因为有安装scripts,所以使用了composer的autoload
    // 一下文字是引用的来源 https://www.yiichina.com/doc/guide/2.0/concept-autoloading
    // 你也可以只使用 Composer 的自动加载，而不用 Yii 的自动加载。
    // 不过这样做的话，类的加载效率会下降， 且你必须遵循 Composer 所设定的规则，
    // 从而让你的类满足可以被自动加载的要求。
    'aliases' => [
        '@Addons' => '@app/Addons',
        '@Backend' => '@app/Backend',
        '@Frontend' => '@app/Frontend',
        '@Api' => '@app/Api',
        '@Console' => '@app/Console',
    ],
    'components' => [
    //扩展DB的能力
        'db' => [
            'schemaMap' =>[
                'mysql' => 'DuAdmin\Mysql\Schema',
                'mysqli' => 'DuAdmin\Mysql\Schema',
            ],
            'queryBuilder' => [
                'expressionBuilders' =>[
                    'DuAdmin\Db\DateRangeCondition' => 'DuAdmin\Db\DateRangeConditionBuilder',
                    'DuAdmin\Db\FullSearchCondition' => 'DuAdmin\Db\FullSearchConditionBuilder'
                ],
                'conditionClasses' => [
                    'DATE_RANGE' => 'DuAdmin\Db\DateRangeCondition',
                    'FULL_SEARCH' => 'DuAdmin\Db\FullSearchCondition'
                ]
            ]
        ]
    ]
];