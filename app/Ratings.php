<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Ratings extends Model
{
    public $timestamps = false;

    protected $table = "ratings";

    use UuidModelTrait;
    protected $primaryKey = 'id';
    public $incrementing = false;
    private static $uuidOptimization = true;

    protected $fillable = ['doctor_id', 'patient_id' , 'rate' ,'rated'];
    
}
