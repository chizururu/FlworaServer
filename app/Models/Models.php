<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

abstract class Models extends Model
{
    // Tambahkan trait HasFactory dan HasApiTokens
    use HasFactory, HasApiTokens;
}
