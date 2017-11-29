<?php

namespace Knowingness\Models;

class Prerequisite extends \Eloquent
{

    protected $table = 'prerequisites';
    protected $guarded = array();
    public static $rules = array();
    protected $fillable = array('course_id', 'description', 'order');

    public function course()
    {
        return $this->belongsTo('Knowingness\Models\Course');
    }

}
