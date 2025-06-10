<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HistoryIrrigation extends Models
{
    // Konfigurasi database dengan protected agar nama table dan field harus sama dengan migrations
    protected $table = 'history_irrigations';
    protected $fillable = ['device_id', 'soil_moisture', 'temperature', 'humidity'];

    /*
     * Relation: History Irrigation (M) to Device (1)
     * */
    public function device(): HasMany
    {
        return $this->hasMany(Device::class, 'id');
    }
}
