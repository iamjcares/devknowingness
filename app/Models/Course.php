<?php

namespace Knowingness\Models;

class Course extends \Eloquent
{

    protected $guarded = array();
    public static $rules = array();
    protected $fillable = array('course_category_id', 'title', 'detail', 'description', 'slug', 'user_id', 'active', 'featured', 'type', 'image', 'price', 'created_at');

    public function tags()
    {
        return $this->belongsToMany('Knowingness\Models\Tag');
    }

    public function category()
    {
        return $this->belongsTo('Knowingness\Models\CourseCategory');
    }

    public function chapters()
    {
        return $this->hasMany('Knowingness\Models\Chapter');
    }

    public function objectives()
    {
        return $this->hasMany('Knowingness\Models\Objective');
    }

    public function requirements()
    {
        return $this->hasMany('Knowingness\Models\Requirement');
    }

    public function prerequisites()
    {
        return $this->hasMany('Knowingness\Models\Prerequisite');
    }

    public function faqs()
    {
        return $this->hasMany('Knowingness\Models\Faq');
    }

}
