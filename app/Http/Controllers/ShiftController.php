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
use DB;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{

    public function startShift()
    {
        $now = Carbon::now();
        $schedule = ScheduleModel::where('id_operator',Auth::user()->id)
        ->where('week',$now->week)->where('month',$now->month)->where('year',$now->year)->first();
        // $extraDetail = ScheduleDetailModel::where('id_schedule',$schedule->id)->where('id_day',$now->dayOfWeek)
        // ->where('type_daily',3)->where('option',1)->orderBy('time_start')->first();
        // dd($extraDetail);
        
        if($schedule == null)
        {
            return response()->json(['error' => 'Schedule not found for this week, contact your teamleader'], 404);
        }

        $scheduleDetail = ScheduleDetailModel::where('id_schedule',$schedule->id)->where('id_day',$now->dayOfWeek)->first();
        $timeclock_exist = TimeClockModel::where('id_schedule',$schedule->id)->where('id_schedule_detail',$scheduleDetail->id)->exists();

        if($scheduleDetail == null)
        {
                return response()->json(['error' => 'Schedule not found for today, contact your teamleader'], 404);
        }

        if($scheduleDetail != null && $timeclock_exist)
        {
            $extraDetail = ScheduleDetailModel::where('id_schedule',$schedule->id)->where('id_day',$now->dayOfWeek)
            ->where('type_daily',3)->where('option',1)->orderBy('time_start')->first();
            if($extraDetail != null)
            {
                $timeclock_exist = TimeClockModel::where('id_schedule',$schedule->id)->where('id_schedule_detail',$extraDetail->id)->exists();

                if($timeclock_exist)
                {
                    return response()->json(['error' => 'You already have a registered extra shift for today'], 404);

                }
                else
                {
                    $time_clock_status = $now <= (Carbon::parse($extraDetail->time_start));
                    if($time_clock_status)
                    {
                        $result = $this->storeShift($schedule,$extraDetail,2);     
                        if(!$result) return response()->json(['error' => 'Start shift already  active'], 404);
                        // return response()->json(['error' => 'in time'], 404);
                        
                    }
                    else
                    {
                        $result = $this->storeShift($schedule,$extraDetail,3);
                        if(!$result) return response()->json(['error' => 'Start shift already active'], 404);
                        // return response()->json(['error' => 'late'], 404);
                    }
                }
                
                
            }
            else
            {

                return response()->json(['error' => 'You already have a registered shift for today'], 404);
            }
        }
        else
        {
            $time_clock_status = $now <= (Carbon::parse($scheduleDetail->time_start));
            if($time_clock_status)
            {
                $result = $this->storeShift($schedule,$scheduleDetail,2);     
                if(!$result) return response()->json(['error' => 'Start shift already  active'], 404);
                // return response()->json(['error' => 'in time'], 404);
                
            }
            else
            {
                $result = $this->storeShift($schedule,$scheduleDetail,3);
                if(!$result) return response()->json(['error' => 'Start shift already active'], 404);
                // return response()->json(['error' => 'late'], 404);
            }
        }
        
        // if($schedule != null)
        // {
        //     $scheduleDetail = ScheduleDetailModel::where('id_schedule',$schedule->id)->where('id_day',$now->dayOfWeek)->first();
        //     $timeclock_exist = TimeClockModel::where('id_schedule',$schedule->id)->where('id_schedule_detail',$scheduleDetail->id)->exists();

        //     if($scheduleDetail != null && !$timeclock_exist)
        //     {
        //         $time_clock_status = $now <= (Carbon::parse($scheduleDetail->time_start));
        //         if($time_clock_status)
        //         {
        //             $result = $this->storeShift($schedule,$scheduleDetail,2);     
        //             if(!$result) return response()->json(['error' => 'Start shift already  active'], 404);
        //             // return response()->json(['error' => 'in time'], 404);
                    
        //         }
        //         else
        //         {
        //             $result = $this->storeShift($schedule,$scheduleDetail,3);
        //             if(!$result) return response()->json(['error' => 'Start shift already active'], 404);
        //             // return response()->json(['error' => 'late'], 404);
        //         }
        //     }
        //     else if($scheduleDetail != null && $timeclock_exist)
        //     {
        //         return response()->json(['error' => 'You already have a registered shift for today'], 404);
        //     }
        //     else
        //     {
        //         return response()->json(['error' => 'Schedule not found for today, contact your teamleader'], 404);
        //     }

        // }
        // else
        // {
        //     return response()->json(['error' => 'Schedule not found for this week, contact your teamleader'], 404);
        // }

    }

    public function endShift()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $schedule = ScheduleModel::where('id_operator',Auth::user()->id)
        ->where('week',$now->week)->where('month',$now->month)->where('year',$now->year)->first();
        $scheduleDetail = ScheduleDetailModel::where('id_schedule',$schedule->id)->where('option',2)->orwhere('option',3)->first();
        
        $time_clock = TimeClockModel::where('id_operator',$user->id)->where('status',1)->first();
        $result = $this->updateShift($scheduleDetail,$time_clock,4); 
        
       
        if(!$result) return response()->json(['error' => "You can't finish your shift before your out time, contact your teamleader"], 404);
       
    }

    public function storeShift($schedule, $scheduleDetail, $state)
    {

            // dd('hola');
        $user = Auth::user()->id;
        if(!TimeClockModel::where('id_operator',$user)->where('status',1)->exists())
        {

            try {
                    DB::beginTransaction();
                        $now = Carbon::now();
                        $scheduleDetail->update(array('option'=> $state));
                            $tmeclock = TimeClockModel::insert([
                            'id_schedule' => $schedule->id, 
                            'id_schedule_detail' => $scheduleDetail->id,
                            'id_operator' => Auth::user()->id, 
                            'date_start' => $now->format('H:i:s'),
                            'date_end' => null, 
                            'duration' => 0,
                            'type' => 0,
                            'status' => 1, ]);
                        
                    DB::commit();
                    return true;
                } catch (\Exception $e) {
                    return response()->json($e);    
                    DB::rollBack();
                    return false;
                }
        }
        else
        {
            return false;
        }

    }

    public function updateShift($scheduleDetail, $time_clock, $state)
    {
        $now = Carbon::now();
        if($now>=(Carbon::parse($scheduleDetail->time_end)))
        {

            try {
                    DB::beginTransaction();
                        
                    $user = Auth::user()->id;
                    $now = Carbon::now();
                    $a = Carbon::parse($time_clock->date_start);
                    $b = Carbon::parse($now);
                    // dd($scheduleDetail->date_start);
                    $totalDuration = $a->diffInSeconds($b);
                    $diferencia = gmdate('H:i:s', $totalDuration);
                    // dd(Carbon::parse($scheduleDetail->date_start)->$now->format('H:i:s'));
                    $scheduleDetail->update(array('option'=> $state));
                    $tmeclock = $time_clock->update(array('date_end'=> $now->format('H:i:s'),'status'=>0,'duration'=>$diferencia));
                    DB::commit();
                    return true;
                } catch (\Exception $e) {
                    return response()->json($e);    
                    DB::rollBack();
                    return false;
                }
        }
        else
        {
            return false;
        }

    }


}
