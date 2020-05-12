<?php
namespace app\mmadmin\widgets;

use app\mmadmin\assets\FloatTheadAsset;
use yii\helpers\Json;
use yii\base\Widget;

/**
 *
 * @author dungang
 */
class FloatThead extends Widget
{

    public $table = 'table';

    public $options = [
        'top'=>'50',
        'scrollingTop'=>'400',
    ];

    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    /**
     * Registers the required assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        FloatTheadAsset::register($view);
        $options = Json::encode($this->options);
        $view->registerJs('$("' . $this->table . '").floatThead(' . $options . ');', $view::POS_READY);
    }
}

