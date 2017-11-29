<?php

namespace Knowingness;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    public static $rules = array();
    protected $fillable = ['name', 'display_name', 'description'];

}
