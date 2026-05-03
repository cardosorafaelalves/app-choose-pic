<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Image extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'images';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'photographer_uuid',
        'customer_uuid',
        'order_uuid',
        'file_url',
        'thumbnail_url',
        'is_selected',
    ];

    protected $casts = [
        'is_selected' => 'boolean',
    ];

    // 🔗 Relationships
    public function photographer()
    {
        return $this->belongsTo(Photographer::class, 'photographer_uuid', 'uuid');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_uuid', 'uuid');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_uuid', 'uuid');
    }
}
