<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SensorMeasurementData extends Models
{
    // Konfigurasi database dengan protected agar nama table dan field harus sama dengan migrations
    protected $table = 'sensor_measurement_data';
    protected $fillable = ['device_id', 'soil_moisture', 'temperature', 'humidity'];

    /*
     * Relation:
     * */
    public function device(): HasMany
    {
        return $this->hasMany(Device::class, 'id');
    }
}
