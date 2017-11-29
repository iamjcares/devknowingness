<?php

namespace Knowingness\Models;

class Tag extends \Eloquent
{

    protected $guarded = array();
    public static $rules = array();

    public function courses()
    {
        return $this->belongsToMany('Knowingness\Models\Course');
    }

}
