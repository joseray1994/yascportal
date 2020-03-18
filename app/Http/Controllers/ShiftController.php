<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\ScheduleDetailModel;
use App\DaysModel;
use App\ClientModel;
use App\SettingsModel;
use App\TimeClockModel;
use App\DayOffModel;
use App\ScheduleModel;
use App\AssignamentTypeModel;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    public function startShift()
    {
        // dd('startShift');
        return response()->json();
    }

    public function endShift()
    {
        // dd('startShift');
        return response()->json();
    }
}
