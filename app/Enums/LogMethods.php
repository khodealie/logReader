<?php

namespace App\Enums;

enum LogMethods: string
{
    case GET = 'GET';
    case POST = 'POST';
    case HEAD = 'HEAD';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
    case CONNECT = 'CONNECT';
    case OPTIONS = 'OPTIONS';
    case TRACE = 'TRACE';
    case PATCH = 'PATCH';
}
