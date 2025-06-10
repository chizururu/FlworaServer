<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Models
{
    // Konfigurasi database dengan protected agar nama table dan field harus sama dengan migrations
    protected $table = 'devices';
    protected $fillable = [
        'id',
        'name',
        'sector_id',
        'status',
        'is_ai_on'];

    /*
     * Relation: Device (M) to Sector (1)
     * */
    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    /*
     * Relation: SensorMeasurementData (M) to Device (1)
     * */
    public function sensorMeasurementData(): BelongsTo
    {
        return $this->belongsTo(SensorMeasurementData::class, 'device_id');
    }

    /*
     * Relation: History Irrigation (M) to Device (1)
     * */
    public function historyIrrigation(): BelongsTo
    {
        return $this->belongsTo(HistoryIrrigation::class, 'device_id');
    }
}
