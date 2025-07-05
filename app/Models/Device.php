<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static firstOrFail(mixed $id)
 */
class Device extends Model
{
    //
    protected $table = 'devices';

    protected $fillable = ['name', 'sector_id', 'is_online', 'ai_status', 'watering'];

    /**
     * relation: Device (M) to Sector (1)
     * @use BelongsTo
     * */
    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }
}
