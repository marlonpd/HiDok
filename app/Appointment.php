<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public $timestamps = true;

    protected $table = "appointment";

    protected $fillable = ['clinic_id','doctor_id', 'patient_id' , 'appointment_date' ,'re_schedule_by_id' ,'note' ,'confirmed'];

	public function patient()
	{
	    return $this->belongsTo('App\User', 'patient_id');
	}

	public function doctor()
	{
	    return $this->belongsTo('App\User', 'doctor_id');
	}
}
