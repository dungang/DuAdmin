<?php

namespace DuAdmin\Hooks;

use DuAdmin\Core\Hook;

/**
 * 查找slug
 * 人性化的url通过slug查找对应的内容
 */
class FindSlugHook extends Hook {

  public $slug;
}