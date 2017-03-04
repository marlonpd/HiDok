<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class ITR extends Model
{
    public $timestamps = true;

    protected $table = "itr";

    use UuidModelTrait;
    protected $primaryKey = 'id';
    public $incrementing = false;
    private static $uuidOptimization = true;

    protected $fillable = ['doctor_id','appointment_id', 'patient_id' , 'assessment' ,'laboratory' ,'diagnosis','treatment'];

	public function patient()
	{
	    return $this->belongsTo('App\User', 'patient_id');
	}

	public function doctor()
	{
	    return $this->belongsTo('App\User', 'doctor_id');
	}
}
