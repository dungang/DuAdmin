<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\FriendLink */

$this->title = Yii::t('da','Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('da_friend_link', 'Friend Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=> Yii::t('da','Create {0} Info',Yii::t('da_friend_link', 'Friend Links')),
    'content'=>$this->render('_form', ['model' => $model,'action'=>['create']])
])?>
