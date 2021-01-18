<?= "<?php\n" ?>
namespace <?=$generator->getFixtureNamespace()?>;

use yii\test\ActiveFixture;

class <?=$fixtureName?> extends ActiveFixture
{
    public $modelClass = '<?=$modelClass?>';

    public $dataFile =  __DIR__ . '/data/<?=$dataName?>.php';
}