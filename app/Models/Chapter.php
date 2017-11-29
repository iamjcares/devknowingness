<?php

namespace Knowingness\Models;

class Chapter extends \Eloquent
{

    protected $guarded = array();
    protected $table = 'chapters';
    public static $rules = array();
    protected $fillable = array('course_id', 'title', 'description', 'order');

    public function course()
    {
        return $this->belongsTo('Knowingness\Models\Course');
    }

    public function lectures()
    {
        return $this->hasMany('Knowingness\Models\Lecture');
    }

}
