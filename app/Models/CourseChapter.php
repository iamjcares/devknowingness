<?php

class CourseChapter extends Eloquent
{

    protected $guarded = array();
    protected $table = 'course_chapters';
    public static $rules = array();
    protected $fillable = array('course_id', 'title', 'description', 'order');

    public function course()
    {
        return $this->belongsTo('Course');
    }

    public function videos()
    {
        return $this->hasMany('Video');
    }

}
