<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasFactory;

	protected $table = 'gallery_items';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'gallery_id',
        'item_value',
        'featured_status',
        'status'
    ];

    /*************************************
     * 
     * @Function: Gallery
     ************************************/
    public function gallery(){
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }  
}
