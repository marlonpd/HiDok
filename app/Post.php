<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Post extends Model
{
    protected $table = 'posts';
    public $timestamps = true;
    use UuidModelTrait;
    protected $primaryKey = 'id';
    public $incrementing = false;
    private static $uuidOptimization = true;

    protected $fillable = ['user_id' , 'content' ,'public' , 'type'];

    public function patient()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
