<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SplashScreen extends Model
{
    protected $table = 'splash_screens';

    protected $fillable = ['image', 'status'];
}
