<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Feedback extends Model
{
    protected $table = 'feedback';
    public $timestamps = true;
    use UuidModelTrait;
    protected $primaryKey = 'id';
    public $incrementing = false;
    private static $uuidOptimization = true;

    protected $fillable = ['doctor_id', 'patient_id' , 'content' ,'approved'];



    public function patient()
    {
        return $this->belongsTo('App\User', 'patient_id');
    }

}
