<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusRoute extends Model
{
    protected $table = 'splash_screens';

    protected $fillable = ['image', 'status'];
}
