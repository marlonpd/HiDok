<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorPatient extends Model
{
    protected $table = 'doctor_patient';

    public $timestamps = true;
    
    protected $fillable = [ 'patient_id', 'doctor_id' ];

    public function patient()
    {
        return $this->belongsTo('App\User', 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo('App\User', 'doctor_id');
    }
}
