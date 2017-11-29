<?php

namespace Knowingness\Libraries;

class CurlHelper
{

    public static function create($url)
    {
        return curl_init($url);
    }

    public function setOpt($ch, $o, $v)
    {
        curl_setopt($ch, $o, $v);
    }

}
