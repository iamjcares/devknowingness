<?php

namespace Knowingness\Models;

class Faq extends \Eloquent
{

    protected $guarded = array();
    public static $rules = array();
    protected $fillable = array('course_id', 'title', 'description');

    public function course()
    {
        return $this->belongsTo('Knowingness\Models\Course');
    }

}
