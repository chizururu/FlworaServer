<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    // Konfigurasi database dengan protected agar nama table dan field harus sama dengan migrations
    protected $table = 'devices';
    protected $fillable = ['id', 'name', 'status', 'is_ai_on', 'sector_id'];

    /*
     * Relation: Device (M) to Sector (1)
     * */
    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }
}
