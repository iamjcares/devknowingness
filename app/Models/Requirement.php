<?php

class Requirement extends Eloquent
{

    protected $table = 'requirements';
    protected $guarded = array();
    public static $rules = array();
    protected $fillable = array('course_id', 'description', 'order');

    public function course()
    {
        return $this->belongsTo('Course');
    }

}
