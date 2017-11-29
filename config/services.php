<?php

return array(
    'mailgun' =>
    array(
        'domain' => '',
        'secret' => '',
    ),
    'mandrill' =>
    array(
        'secret' => '',
    ),
    'ses' =>
    array(
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
    ),
    'facebook' =>
    array(
        'client_id' => '1970494466528756',
        'client_secret' => '431cad00f7840343b70ef8b5b31debd1',
        'redirect' => 'http://dev.knowingness/social/login/facebook',
    ),
    'twitter' =>
    array(
        'client_id' => 'Sz53XaXT8NUWxKosIoTx8oodw',
        'client_secret' => 'gySiKwbF7GVoxMqvV7IrRINWBBQevSaHb1zf2kLjSJwpv3JKvv',
        'redirect' => 'http://dev.knowingness.com/social/login/twitter',
    ),
    'google' =>
    array(
        'client_id' => '264400969420-0sgmgfpga20tkljdb7cl27i3vrv3q7o3.apps.googleusercontent.com',
        'client_secret' => 'zwQscxNcGKfJIXgMXOm79zzq',
        'redirect' => 'http://dev.knowingness.com/social/login/google',
    ),
    'stripe' =>
    [
        'model' => 'User',
        'secret' => '',
    ],
);
