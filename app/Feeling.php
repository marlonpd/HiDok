<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Feeling extends Model
{
    protected $table = 'feelings';
    public $timestamps = true;
    use UuidModelTrait;
    protected $primaryKey = 'id';
    public $incrementing = false;
    private static $uuidOptimization = true;

    protected $fillable = ['patient_id' , 'content' ,'private'];



    public function patient()
    {
        return $this->belongsTo('App\User', 'patient_id');
    }
}
