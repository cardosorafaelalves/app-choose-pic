<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PhotographerConfig extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'photographers_configs';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'photographer_uuid',
        'logo_url',
        'primary_color',
        'secondary_color',
        'welcome_message',
        'send_email_on_choice',
        'email_template_id',
    ];

    // 🔗 Relationships
    public function photographer()
    {
        return $this->belongsTo(Photographer::class, 'photographer_uuid', 'uuid');
    }
}
