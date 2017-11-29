<?php

namespace Knowingness\Models;

class Lecture extends \Eloquent
{

    protected $guarded = array();
    public static $rules = array();
    protected $fillable = array('chapter_id', 'type', 'title', 'description', 'order', 'preview', 'duration', 'link', 'image');

    public function chapter()
    {
        return $this->belongsTo('Knowingness\Models\Chapter');
    }

}
