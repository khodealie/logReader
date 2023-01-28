<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountRes;
use App\Models\Log;
use App\Rules\ServiceExists;
use Illuminate\Http\Request;

class LogController extends Controller
{
    //get count of log file
    public function count(Request $request)
    {
        $request->validate([
            'serviceNames' => [new ServiceExists],
            'statusCode' => ['bail','numeric', 'max:599', 'min:100'],
            'startDate' => ['date'],
            'endDate' => ['bail','date', 'after:startDate']
        ]);
        return new CountRes(log::filterViaParams($request->query()));
    }
}
