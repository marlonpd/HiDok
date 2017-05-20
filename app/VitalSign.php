<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class VitalSign extends Model
{
    use UuidModelTrait;

    protected $table = 'vital_signs';
    protected $primaryKey = 'id';
    public $incrementing = false;
    private static $uuidOptimization = true;
    public $timestamps = false;

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
        return $this->belongsTo('App\Consultation', 'consultation_id');
   }

}
