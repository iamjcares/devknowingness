<?php

namespace Knowingness\Models;

class Cart extends \Eloquent
{

    protected $guarded = array();
    public static $rules = array();
    protected $fillable = array('user_id', 'instance', 'description');

    public function courses()
    {
        return $this->belongsToMany('Knowingness\Models\Course');
    }

    public function user()
    {
        return $this->belongsTo('Knowingness\User');
    }

}
