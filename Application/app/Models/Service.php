<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'marina_id',
        'category_id',
        'sub_category_id',
        'service_name',
        'service_icon',
        'distance',
        'address',
        'latitude',
        'longitude',
        'heading',
        'description',
        'contact_number',
        'status'
    ];

    /**
     * Category
     */
    public function marina()
    {
        return $this->belongsTo(Marina::class, 'marina_id');
    }

    /**
     * Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
	
    /**
     * Sub Category
     */
    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id', 'id');
    }

    const port_name = [
        '1' => 'Kandla',
        '2' => 'Mangalore',
        '3' => 'JNPT',
        '4' => 'Mormugao',
        '5' => 'Mumbai',
        '6' => 'Cochin',
    ];
}
