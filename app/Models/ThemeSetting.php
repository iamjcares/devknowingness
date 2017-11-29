<?php

namespace Knowingness\Models;

class ThemeSetting extends \Eloquent
{

    protected $guarded = array();
    public static $rules = array();
    protected $fillable = array('theme_slug', 'key', 'value');

}
