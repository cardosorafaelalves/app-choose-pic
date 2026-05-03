<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Customer extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'customers';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'photographer_uuid',
        'name',
        'email',
        'access_token',
    ];

    // 🔗 Relationships
    public function photographer()
    {
        return $this->belongsTo(Photographer::class, 'photographer_uuid', 'uuid');
    }

    public function config()
    {
        return $this->hasOne(CustomerConfig::class, 'customer_uuid', 'uuid');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_uuid', 'uuid');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'customer_uuid', 'uuid');
    }
}
