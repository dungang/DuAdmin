<?php
namespace Console;

use yii\faker\FixtureController;
use yii\helpers\FileHelper;
use yii\console\Exception;

class DuaFixtureController extends FixtureController
{
    public $language = 'zh-CN';
    
    public $addonName = '';
    
    public $count = 1;
    
    /**
     * {@inheritdoc}
     */
    public function options($actionID)
    {
        return array_merge(parent::options($actionID), [
            'addonName', 'templatePath', 'language', 'fixtureDataPath', 'count'
        ]);
    }
    
    public function checkPaths() {
        return true;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \yii\faker\FixtureController::actionGenerateAll()
     */
    public function actionGenerateAll() {
       
        $this->templatePath = '@Addons/' . $this->addonName . '/Tests/Unit/Fixtures/templates';
        $this->fixtureDataPath =  '@Addons/' . $this->addonName . '/Tests/Unit/Fixtures/data';

        $foundTemplates = $this->findTemplatesFiles();
        
        if (!$foundTemplates) {
            $this->notifyNoTemplatesFound();
            return static::EXIT_CODE_NORMAL;
        }
        
        if (!$this->confirmGeneration($foundTemplates)) {
            return static::EXIT_CODE_NORMAL;
        }
        
        $templatePath = \Yii::getAlias($this->templatePath);
        $fixtureDataPath = \Yii::getAlias($this->fixtureDataPath);
        
        FileHelper::createDirectory($fixtureDataPath);
        
        $generatedTemplates = [];
        
        foreach ($foundTemplates as $templateName) {
            $this->generateFixtureFile($templateName, $templatePath, $fixtureDataPath);
            $generatedTemplates[] = $templateName;
        }
        
        $this->notifyTemplatesGenerated($generatedTemplates);
    }
    
    /**
     * Loads the specified fixture data.
     *
     * For example,
     *
     * ```
     * # load the fixture data specified by User and UserProfile.
     * # any existing fixture data will be removed first
     * yii fixture/load "User, UserProfile"
     *
     * # load all available fixtures found under 'tests\unit\fixtures'
     * yii fixture/load "*"
     *
     * # load all fixtures except User and UserProfile
     * yii fixture/load "*, -User, -UserProfile"
     * ```
     *
     * @param array $fixturesInput
     * @return int return code
     * @throws Exception if the specified fixture does not exist.
     */
    public function actionLoad(array $fixturesInput = []){
        
        if($this->addonName) {
            $this->namespace = 'Addons\\' . $this->addonName .'\\Tests\\Unit\Fixtures';
        }
        parent::actionLoad($fixturesInput);
    }
}

