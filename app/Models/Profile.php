<?php

class Profile extends Eloquent
{

    protected $fillable = [
        'photo',
        'user_id',
        'contact_number',
        'alternate_contact_number',
        'alternate_email',
        'address',
        'timezone_id'
    ];
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo('HelloVideo\User');
    }

}
