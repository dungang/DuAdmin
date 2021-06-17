<?php
namespace Addons\Cms\Widgets;

use DuAdmin\Widgets\BasePageBlock;
use Addons\Cms\Models\Flash;

class SwiperBlock extends BasePageBlock
{
    use SwiperTrait;

    public function renderPageBlock()
    {
        $this->settingSwiper();
        return $this->render('swiper', [
            'block' => $this->model,
            'items' => $this->query->all(),
            'widget' => $this
        ]);
    }

    public function initQuery()
    {
        $this->query = Flash::find();
    }
}