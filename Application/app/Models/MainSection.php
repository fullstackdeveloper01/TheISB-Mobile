<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainSection extends Model
{
    use HasFactory;

	protected $table = 'main_sections';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'heading',
        'icon',
        'file_type',
        'file_value',
        'line_color',
        'app_version',
        'status'
    ];
}
