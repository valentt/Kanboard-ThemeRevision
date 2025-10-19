<?php

namespace Kanboard\Plugin\ThemeRevisionPlus\Helper;
use Kanboard\Core\Base;
use Kanboard\Plugin\ThemeRevisionPlus\Plugin;

class BaseHelper extends Base
{
    protected function getPlugin(){
        return Plugin::getInstance($this->container);
    }
}
