<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Term extends Model
{
    use UuidModelTrait;

    protected $table = 'terms';
    protected $primaryKey = 'id';
    public $incrementing = false;
    private static $uuidOptimization = true;
}
