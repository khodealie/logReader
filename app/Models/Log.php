<?php

namespace App\Models;

use App\Enums\LogMethods;
use App\Enums\LogServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $casts = [
        'service' => LogServices::class,
        'method' => LogMethods::class
    ];
}
