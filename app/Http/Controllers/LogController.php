<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Spatie\Activitylog\Models\Activity;

/**
 * Class LogController
 * @package App\Http\Controllers
 */
class LogController extends Controller
{
    /**
     * @return Response
     */
    public function activityLog(Request $request)
    {


        return response()->json(['log' => Activity::all()], 200);
    }
}
