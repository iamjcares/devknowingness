<?php

class Favorite extends Eloquent
{

    protected $table = 'favorites';
    protected $guarded = array();
    public static $rules = array();
    protected $fillable = array('user_id', 'course_id');

    public function user()
    {
        return $this->belongsTo('User')->first();
    }

    public function course()
    {
        return $this->belongsTo('Course')->first();
    }

}
