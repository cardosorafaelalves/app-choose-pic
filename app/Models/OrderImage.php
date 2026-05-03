<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderImage extends Model
{
    use HasFactory;

    protected $table = 'order_images';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'order_uuid',
        'image_uuid',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_uuid', 'uuid');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_uuid', 'uuid');
    }
}
