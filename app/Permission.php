<?php

namespace HelloVideo;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{

    public static $rules = array();

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'description', 'category'];

}
