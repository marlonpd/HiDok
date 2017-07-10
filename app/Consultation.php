<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Consultation extends Model
{
    use UuidModelTrait;
	public $timestamps = true;    
    protected $primaryKey = 'id';
    public $incrementing = false;
    private static $uuidOptimization = true;

    protected $fillable = [ 'doctor_id','patient_id', 'type','admit', 'hospital'];

    public function patient()
    {
        return $this->belongsTo('App\User', 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo('App\User', 'doctor_id');
    }

}
