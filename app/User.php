<?php

namespace App;
use Eloquent;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;


class User extends Eloquent implements Authenticatable
{
    use Notifiable;
    use AuthenticableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastname','firstname','middlename','account_type','name', 
        'email', 'password','address','contact_no','height','weight',
        'religion','gender','photo', 'thumbnail','health_history','specialization',
        'consultation_fee'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function avatar()
    {
        return $this->photo == "" ? '/images/default_avatar_male.jpg' : $this->thumbnail;
    }

    public function is_doctor()
    {
        return $this->account_type == config('constants.account_type.doctor') ? true : false;
    }


    public function is_patient()
    {
        return $this->account_type == config('constants.account_type.patient') ? true : false;
    }

    
}
