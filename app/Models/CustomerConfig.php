<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CustomerConfig extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'customers_configs';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'customer_uuid',
        'max_photos',
        'photo_price',
        'gallery_expiration',
        'allow_download',
        'watermark_enabled',
    ];

    // 🔗 Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_uuid', 'uuid');
    }
}
