<?php

namespace Knowingness\Libraries;

class ConfigHelper
{

    public static function getServices()
    {
        return File::getRequire(base_path() . config('paths.SERVICE_PATH'));
    }

}
