<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UCodes extends Model
{
    protected $fillable = ['service_name', 'id_name', 'password', 'mail', 'detail'];
}
