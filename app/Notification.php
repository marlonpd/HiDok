<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Notification extends Model
{
    protected $table = 'notifications';
    public $timestamps = true;
    use UuidModelTrait;
    protected $primaryKey = 'id';
    public $incrementing = false;
    private static $uuidOptimization = true;

    protected $fillable = ['recepient_id' , 'sender_id' ,'read','content','item_id' ,'url', 'type'];

    public function recepient()
    {
        return $this->belongsTo('App\User', 'recepient_id');
    }

    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }
}
