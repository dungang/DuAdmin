<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\generators\crud\Generator */

$modelClass = StringHelper::basename( $generator->modelClass );
$searchModelClass = StringHelper::basename( $generator->searchModelClass );
if ($modelClass === $searchModelClass) {
  $modelAlias = $modelClass . 'Model';
}
$rules = $generator->generateSearchRules();
$searchConditions = $generator->generateSearchConditions();

echo "<?php\n";
?>

namespace <?=StringHelper::dirname( ltrim( $generator->searchModelClass, '\\' ) )?>;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * <?=$searchModelClass?> represents the model behind the search form of `<?=$generator->modelClass?>`.
 */
class <?=$searchModelClass?> extends <?=isset( $modelAlias ) ? $modelAlias : $modelClass?>

{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            <?=implode( ",\n            ", $rules )?>,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return parent::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @param string|NULL $formName
     *
     * @return ActiveDataProvider
     */
    public function search($params = [], $formName = NULL)
    {
        $query = <?=isset( $modelAlias ) ? $modelAlias : $modelClass?>::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
<?php

if ($generator->enableDefaultOrder) :
  ?>
		    'sort' => [
               'defaultOrder' => [
                   '<?=$generator->defaultOrderField?>' => <?=$generator->defaultOrder?>
                   
               ]
            ]
<?php endif;

?>
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        <?=implode( "\n        ", $searchConditions )?>

        return $dataProvider;
    }
}
