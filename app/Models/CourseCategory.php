<?php

namespace Knowingness\Models;

class CourseCategory extends \Eloquent
{

    protected $guarded = array();
    protected $table = 'course_categories';
    public static $rules = array();

    //protected $fillable = array('', '');

    public function courses()
    {
        return $this->hasMany('Knowingness\Models\Course');
    }

    public function hasChildren()
    {
        if (\DB::table('course_categories')->where('parent_id', '=', $this->id)->count() >= 1) {
            return true;
        } else {
            return false;
        }
    }

}
