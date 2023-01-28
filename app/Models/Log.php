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

    public static function filterViaParams(array $listParams)
    {
        $newInstance = new static();
        foreach ($listParams as $query => $params) {

            if ($query == 'serviceNames' || $query == 'serviceName')
                $newInstance = (is_array($params)) ?
                    $newInstance->whereIn('service', $params) :
                    $newInstance->where('service', $params);

            if ($query == 'statusCodes' || $query == 'statusCode')
                $newInstance = (is_array($params)) ?
                    $newInstance->whereIn('status', $params) :
                    $newInstance->where('status', $params);

            if ($query == 'methods' || $query == 'method')
                $newInstance = (is_array($params)) ?
                    $newInstance->whereIn('method', $params) :
                    $newInstance->where('method', $params);

            if ($query == 'endpoints' || $query == 'endpoint')
                $newInstance = (is_array($params)) ?
                    $newInstance->whereIn('endpoint', $params) :
                    $newInstance->where('endpoint', $params);

            if ($query == 'startDate')
                $newInstance = $newInstance->whereDate('created_at', '>=', $params);

            if ($query == 'endDate')
                $newInstance = $newInstance->whereDate('created_at', '<=', $params);
        }
        return $newInstance;
    }

}
