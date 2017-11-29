<?php

namespace Knowingness\Models;

class Order extends \Eloquent
{

    protected $guarded = array();
    public static $rules = array();
    protected $fillable = array('user_id', 'code', 'payment_id', 'description', 'status', 'payment_method');

    public function items()
    {
        return $this->hasMany('Knowingness\Models\OrderItem');
    }

    public function user()
    {
        return $this->belongsTo('Knowingness\User');
    }

}
