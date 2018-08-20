<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'expires_at'
    ];
}
