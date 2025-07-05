<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sector extends Model
{
    protected $table = 'sectors';
    protected $fillable = ['name', 'user_id'];

    /**
     * relation Sector (M) to User (1)
     * @use BelongsTo
     * */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * relation Sector (1) to Device (M)
     * @use HasMany
     * */
    public function device(): HasMany
    {
        return $this->hasMany(Device::class, 'sector_id');
    }
}
