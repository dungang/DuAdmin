<?php
namespace DuAdmin\Behaviors;

use DuAdmin\Multilingual\MultilingualBehavior;
use Yii;
use DuAdmin\Helpers\AppHelper;

class LanguageBehavior extends MultilingualBehavior
{

    /**
     *
     * @inheritdoc
     */
    public $requireTranslations = true;

    /**
     *
     * @inheritdoc
     */
    public $abridge = false;

    /**
     *
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->languages = AppHelper::getSettingAssoc('site.i18n');
        $this->defaultLanguage = Yii::$app->request->get('language', Yii::$app->language);
    }
}

