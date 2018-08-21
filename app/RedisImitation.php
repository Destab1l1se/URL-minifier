<?php

namespace App;

use App\Tools\UrlValidator;
use Illuminate\Database\Eloquent\Model;

class RedisImitation extends Model
{
    public $table = 'redis_imitation';
    public $primaryKey = 'key';
}
