<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public $timestamps = true;

    protected $table = "appointment";

    protected $fillable = ['schedule_id','doctor_id', 'patient_id' , 'appointment_date' ,'note' ,'confirmed'];

	public function patient()
	{
	    return $this->belongsTo('App\User', 'patient_id');
	}

	public function doctor()
	{
	    return $this->belongsTo('App\User', 'doctor_id');
	}
}
