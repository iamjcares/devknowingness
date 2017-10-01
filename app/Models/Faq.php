<?php

class Faq extends Eloquent
{

    protected $table = 'faqs';
    protected $guarded = array();
    public static $rules = array();
    protected $fillable = array('course_id', 'title', 'description');

    public function course()
    {
        return $this->belongsTo('Course');
    }

}
