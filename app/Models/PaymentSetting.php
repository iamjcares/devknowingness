<?php

namespace Knowingness\Models;

class PaymentSetting extends \Eloquent
{

    protected $guarded = array();
    public static $rules = array();
    public $timestamps = false;
    protected $fillable = array('enable_paypal', 'enable_stripe', 'paypal_live_mode', 'stripe_live_mode', 'paypal_test_secret_key', 'paypal_test_publishable_key',
        'paypal_live_secret_key', 'paypal_live_publishable_key', 'stripe_test_secret_key', 'stripe_test_publishable_key', 'stripe_live_secret_key', 'stripe_live_publishable_key');

}
