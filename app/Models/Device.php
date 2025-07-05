<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    //
    protected $table = 'devices';

    protected $fillable = ['name', 'sector_id', 'is_online', 'ai_status', 'watering'];

    /**
     * relation:
     * */
}
