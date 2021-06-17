<?php
namespace Addons\Cms\Widgets;

use Addons\Cms\Models\Post;
use yii\base\Widget;

class PostNav extends Widget {

    public $id;

    public function run(){
        return $this->render('post-nav',[
            'prevModel' => $this->findPrev(),
            'nextModel' => $this->findNext()
        ]);
    }

    public function findPrev(){
        return Post::find()->where(['<','id',$this->id])->limit(1)->one();
    }

    public function findNext() {
        return Post::find()->where(['>','id',$this->id])->limit(1)->one();
    }
}