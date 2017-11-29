<?php

namespace Knowingness\Models;

class OrderItem extends \Eloquent
{

    protected $guarded = [];
    public static $rules = [];
    protected $fillable = ['course_id', 'order_id', 'price'];
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('Knowingness\Models\Order');
    }

    public function course()
    {
        return $this->belongsTo('Knowingness\Models\Course');
    }

}
