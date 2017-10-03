<?php

class Course extends Eloquent
{

    protected $guarded = array();
    public static $rules = array();
    protected $fillable = array('course_category_id', 'title', 'detail', 'description', 'slug', 'user_id', 'active', 'featured', 'type', 'image', 'price', 'created_at');

    public function tags()
    {
        return $this->belongsToMany('Tag');
    }

    public function category()
    {
        return $this->belongsTo('CourseCategory');
    }

    public function chapters()
    {
        return $this->hasMany('Chapter');
    }

    public function objectives()
    {
        return $this->hasMany('Objective');
    }

    public function requirements()
    {
        return $this->hasMany('Requirement');
    }

    public function prerequisites()
    {
        return $this->hasMany('Prerequisite');
    }

    public function faqs()
    {
        return $this->hasMany('Faq');
    }

}
