<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntroScreen extends Model
{
    protected $table = 'intro_screens';

    protected $fillable = ['title', 'screen', 'status'];
}
