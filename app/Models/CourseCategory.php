<?php

class CourseCategory extends Eloquent
{

    protected $guarded = array();
    protected $table = 'course_categories';
    public static $rules = array();

    //protected $fillable = array('', '');

    public function courses()
    {
        return $this->hasMany('Course');
    }

    public function hasChildren()
    {
        if (DB::table('course_categories')->where('parent_id', '=', $this->id)->count() >= 1) {
            return true;
        } else {
            return false;
        }
    }

}
