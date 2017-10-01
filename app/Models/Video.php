<?php

class Video extends Eloquent
{

    protected $guarded = array();
    public static $rules = array();
    protected $fillable = array('course_category_id', 'title', 'detail', 'description', 'user_id', 'active', 'featured', 'type', 'image', 'price', 'created_at');

    public function tags()
    {
        return $this->belongsToMany('Tag');
    }

}
