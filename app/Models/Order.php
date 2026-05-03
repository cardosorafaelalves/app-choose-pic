<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'orders';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'customer_uuid',
        'photographer_uuid',
        'total_photos',
        'total_amount',
        'status',
        'payment_gateway',
        'payment_id',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
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

    public function images()
    {
        return $this->hasMany(Image::class, 'order_uuid', 'uuid');
    }
}
