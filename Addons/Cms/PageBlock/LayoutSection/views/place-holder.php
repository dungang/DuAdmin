<?php

use Addons\Cms\PageBlock\ElementDialogButton\PlaceHolder;
use Addons\Cms\PageBlock\LayoutSection\Asset;

echo Asset::widget();
/** @var int $pageBlockId * */
?>
<div class="element-section clearfix">
    <div class="row row-no-gutters">
        <div class="col-md-6">
            <div class="img-holder" style="background-image: url('/images/login-bg.png')"></div>
        </div>
        <div class="col-md-6 ">
            <div class="du-live-element element-section-info">
                <h2>Hello DUAdmin!</h2>
                <p> DUAdmin是一个YII2的应用后台开发框架系统.DUAdmin是一个YII2的应用后台开发框架系统.DUAdmin是一个YII2的应用后台开发框架系统.</p>
                <?= PlaceHolder::widget() ?>
            </div>
        </div>
    </div>
</div>