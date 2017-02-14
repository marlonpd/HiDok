<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $timestamps = false;

    protected $fillable = [
        'user_id' , 'from_time' , 'to_time', 'from_day' , 'to_day' , 'address',
        'gmap_lat' , 'gmap_lng' , 'default_address'
    ];


    public function is_default()
    {
        return $this->default_address == 1 ? true : false;
    }
}
