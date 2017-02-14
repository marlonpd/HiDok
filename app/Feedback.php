<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    public $timestamps = true;

    protected $fillable = ['doctor_id', 'patient_id' , 'content' ,'approved'];



    public function patient()
    {
        return $this->belongsTo('App\User', 'patient_id');
    }

}
