<?php

namespace Knowingness\Models;

class PostCategory extends \Eloquent
{

    protected $guarded = array();
    protected $table = 'post_categories';
    public static $rules = array();

    public function posts()
    {
        return $this->hasMany('Knowingness\Models\Post');
    }

    public function hasChildren()
    {
        if (\DB::table('post_categories')->where('parent_id', '=', $this->id)->count() >= 1) {
            return true;
        } else {
            return false;
        }
    }

}
