<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sector extends Models
{
    // Konfigurasi database dengan protected agar nama table dan field harus sama dengan migrations
    protected $table = 'sectors';
    protected $fillable = ['name', 'user_id'];

    /*
     * Relation: Sector (M) to User (1)
     * */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
     * Relation: Sector (1) to Device (M)
     * */
    public function device(): HasMany
    {
        return $this->hasMany(Device::class, 'sector_id');
    }
}
