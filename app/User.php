<?php

namespace Knowingness;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
//use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
//use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Notifications\Notifiable;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable,
//        Authorizable,
        CanResetPassword,
        Notifiable,
        EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'username', 'active', 'email', 'avatar', 'password', 'status', 'disabled'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    protected $dates = ['trial_ends_at', 'subscription_ends_at'];
    public static $rules = array('username' => 'required|unique:users|min:3',
        'email' => 'required|email|unique:users',
        'name' => 'required|min:3',
        'password' => 'required|confirmed|min:3'
    );
    public static $update_rules = array('username' => 'unique:users|min:3',
        'email' => 'email|unique:users'
    );

    public function profile()
    {
        return $this->hasOne('Profile');
    }

    public function cart()
    {
        return $this->hasOne('Knowingness\Models\Cart');
    }

}
