<?php

class Chapter extends Eloquent
{

    protected $guarded = array();
    protected $table = 'chapters';
    public static $rules = array();
    protected $fillable = array('course_id', 'title', 'description', 'order');

    public function course()
    {
        return $this->belongsTo('Course');
    }

    public function lectures()
    {
        return $this->hasMany('Lecture');
    }

}
