<?php

namespace Knowingness\Models;

class Enrolment extends \Eloquent
{

    protected $guarded = array();
    public static $rules = array();
    protected $fillable = array('user_id', 'course_id', 'order_id', 'status');

    public function user()
    {
        return $this->belongsTo('Knowingness\User')->first();
    }

    public function course()
    {
        return $this->belongsTo('Knowingness\Models\Course')->first();
    }

}
