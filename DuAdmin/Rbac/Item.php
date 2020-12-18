<?php


namespace DuAdmin\Rbac;

use yii\base\BaseObject;

/**
 * For more details and usage information on Item, see the [guide article on security authorization](guide:security-authorization).
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Item extends BaseObject
{
    const TYPE_ROLE = 1;

    const TYPE_PERMISSION = 2;

    const TYPE_GROUP = 3;

    /**
     * @var int the type of the item. This should be either [[TYPE_ROLE]] or [[TYPE_PERMISSION]].
     */
    public $type;
    /**
     * @var string the id of the item. This must be globally unique.
     */
    public $id;
    /**
     * @var string the item name
     */
    public $name;
    /**
     * @var string id of the rule associated with this item
     */
    public $ruleId;
    /**
     * @var mixed the additional data associated with this item
     */
    public $data;
    /**
     * @var string Datetime  representing the item creation time
     */
    public $createdAt;
    /**
     * @var string Datetime representing the item updating time
     */
    public $updatedAt;
}
