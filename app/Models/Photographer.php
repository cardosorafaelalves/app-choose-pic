<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Photographer extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'photographers';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'email',
        'subdomain',
        'active',
    ];

    // 🔗 Relationships
    public function config()
    {
        return $this->hasOne(PhotographerConfig::class, 'photographer_uuid', 'uuid');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'photographer_uuid', 'uuid');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'photographer_uuid', 'uuid');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'photographer_uuid', 'uuid');
    }
}
