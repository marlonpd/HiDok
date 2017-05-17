<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class ChiefComplaint extends Model
{
    use UuidModelTrait;

	public $timestamps = false;    
    protected $primaryKey = 'id';
    public $incrementing = false;
    private static $uuidOptimization = true;
    
    protected $fillable = [ 'patient_id', 'consultation_id', 'doctor_id'];

    public function patient()
    {
        return $this->belongsTo('App\User', 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo('App\User', 'doctor_id');
    }

   public function consultation()
    {
        return $this->belongsTo('App\User', 'consultation_id');
    }
}
