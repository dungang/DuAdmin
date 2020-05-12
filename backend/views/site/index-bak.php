<?php
use app\mmadmin\models\Setting;
use yii\data\ActiveDataProvider;
use app\addons\cms\models\Article;
use app\mmadmin\grids\GridView;
use yii\widgets\ListView;
use app\mmadmin\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = '首页';
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Setting::getSettings('site.keywords')
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => Setting::getSettings('site.description')
]);
?>
<div class="row">
	<div class="col-md-9">
		<h3>
			<i class="fa fa-newspaper-o"></i> 最新资讯
		</h3>
<?php
$dataProvider = new ActiveDataProvider([
    'query' => Article::find()->orderBy('created_at')->limit(10),
    'sort' => false,
    'pagination' => false
]);
echo GridView::widget([
    'tableOptions' => [
        'class' => 'table table-bordered'
    ],
    'dataProvider' => $dataProvider,
    'summary' => false,
    'showHeader' => false,
    'columns' => [
        [
            'attribute' => 'title',
            'format' => 'raw',
            'value' => function ($model) {
                return '[' . \Yii::$app->formatter->asDate($model->created_at) . '] ' . \yii\helpers\Html::a($model->title, [
                    '/cms/default/show',
                    'id' => $model->id
                ]);
            }
        ]
    ]
]);
?>
	</div>

	<div class="col-md-3">
		<div class="alert alert-danger">
			<strong>无感注册！支付宝直接登录！</strong>
			<p>请点击导航栏“登录”</p>
		</div>


		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">最新用户</h3>
			</div>
			<div class="panel-body">
				<?php
    $dataProvider = new ActiveDataProvider([
        'query' => User::find()->orderBy('created_at desc')
            ->where([
            'is_admin' => 0
        ])
            ->limit(10),
        'sort' => false,
        'pagination' => false
    ]);
    echo ListView::widget([
        'layout' => "<ul class='row'>{items}</ul>",
        'dataProvider' => $dataProvider,
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::tag('li', $model->nick_name);
        }
    ]);
    ?>
			</div>
		</div>
	</div>

</div>
