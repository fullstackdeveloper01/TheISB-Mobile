<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionOther extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "section_others";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'section_id',
        'title',
        'title_color',
        'sub_title',
        'sub_title_color',
        'icon',
        'icon_color',
        'btn_color',
        'box_color',
        'redirection',
        'redirection_url',
        'status',
    ];
}
