<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Clinic extends Model
{
    use UuidModelTrait;

	public $timestamps = false;    
    protected $primaryKey = 'id';
    public $incrementing = false;
    private static $uuidOptimization = true;
    
    protected $fillable = [ 'name',
        'doctor_id' , 'from_time' , 'to_time', 'open_sunday' , 'open_monday','open_tuesday','open_wednesday',
        'open_thursday','open_friday' , 'open_saturday' , 'address',
        'gmap_lat' , 'gmap_lng' , 'default_address'
    ];

    public function is_default()
    {
        return $this->default_address == 1 ? true : false;
    }

    public function appointment()
    {
        return $this->belongsTo('App\Appointment', 'doctor_id');
    }


    public function available_day()
    {
        $days = '';
        $days .= $this->open_sunday == 1 ? 'Sunday, ' : ''; 
        $days .= $this->open_monday == 1 ? 'Monday, ' : '';
        $days .= $this->open_tuesday == 1 ? 'Tuesday, ' : '';
        $days .= $this->open_wednesday == 1 ? 'Wednesday, ' : '';
        $days .= $this->open_thursday == 1 ? 'Thursday, ' : '';
        $days .= $this->open_friday == 1 ? 'Friday, ' : '';
        $days .= $this->open_saturday == 1 ? 'Saturday': '';  
  
        return $days;
    }



}
