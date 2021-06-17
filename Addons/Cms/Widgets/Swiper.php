<?php
namespace Addons\Cms\Widgets;

use Addons\Cms\Models\Flash;
use DuAdmin\Widgets\DefaultFlashSwiper;

class Swiper extends DefaultFlashSwiper
{
    use SwiperTrait;

    public function run()
    {
        $this->settingSwiper();
        if ($items = $this->getItems()) {
            return $this->render('swiper', [
                'items' => $items,
                'widget' => $this
            ]);
        }

        return null;
    }

    public function getItems()
    {
        return Flash::find()->orderBy('sort desc')
            ->limit($this->size)
            ->all();
    }
}
