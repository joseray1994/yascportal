<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
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

class ScheduleDailyController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {           
        $user = Auth::user();
        $id_menu=5;
        $menu = menu($user,$id_menu);
        if($menu['validate']){ 
                $operators=User::select('users.id as id', 'ui.name as name', 'ui.last_name as lname')
                ->join('users_info as ui', 'ui.id_user', '=', 'users.id')
                ->where('users.id_type_user','=',9)
                ->get();
                $days= DaysModel::all();
                $settings= SettingsModel::all();
                $clients=ClientModel::all();

                if($request->date !=""){
                    $now =Carbon::parse($request->date);

                    $data2 = ScheduleDetailModel::select( "detail_schedule_user.id as id", "detail_schedule_user.type_daily as type", "inf.name as name", "inf.last_name as lastname","cli.name as client","ccl.hex as color",'set.name as setting','detail_schedule_user.time_start as time_s','detail_schedule_user.time_end as time_e',"detail_schedule_user.status as status")
                    ->join('schedule as sch','sch.id', "=", 'detail_schedule_user.id_schedule')
                    ->join('clients as cli', 'cli.id',"=","sch.id_client")
                    ->join('client_color as ccl', 'ccl.id',"=","cli.color")
                    ->join('users_info as inf','inf.id_user', "=", 'detail_schedule_user.id_operator')
                    ->join('settings as set','set.id','=','detail_schedule_user.option')
                    ->where('sch.week',"=", $now->weekOfYear)
                    ->where('sch.month',"=", $now->month)
                    ->where('sch.year',"=", $now->year)
                    ->where('detail_schedule_user.status',1)
                    ->where('detail_schedule_user.id_day',"=", $now->dayOfWeek);
                    
                    if($request->operator != "all"){
                        $data2->where('detail_schedule_user.id_operator',"=", $request->operator);
                    }
                    if($request->client != "all"){
                        $data2->where('sch.id_client',"=", $request->client);
                    }

                } else{
                    $now = Carbon::now();
                    $data2 = ScheduleDetailModel::select( "detail_schedule_user.id as id", "detail_schedule_user.type_daily as type", "inf.name as name", "inf.last_name as lastname","cli.name as client","ccl.hex as color",'set.name as setting','detail_schedule_user.time_start as time_s','detail_schedule_user.time_end as time_e',"detail_schedule_user.status as status")
                    ->join('schedule as sch','sch.id', "=", 'detail_schedule_user.id_schedule')
                    ->join('clients as cli', 'cli.id',"=","sch.id_client")
                    ->join('client_color as ccl', 'ccl.id',"=","cli.color")
                    ->join('users_info as inf','inf.id_user', "=", 'detail_schedule_user.id_operator')
                    ->join('settings as set','set.id','=','detail_schedule_user.option')
                    ->where('detail_schedule_user.id_day',"=", $now->dayOfWeek)
                    ->where('sch.week',"=", $now->weekOfYear)
                    ->where('sch.month',"=", $now->month)
                    ->where('sch.year',"=", $now->year)
                    ->where('detail_schedule_user.status',1);

                    $day = DaysModel::where('id',$now->dayOfWeek)->first();
                    
                } 
                $data = $data2->get();
            

                if ($request->ajax()) {
                    return view('schedule.daily.table', ["data"=>$data]);
                }
            
        return view('schedule.daily.index',["data"=>$data,'day'=>$day,'date'=>$now,"days"=>$days,"settings"=>$settings ,"today"=>$now->toDateString(),"NoD"=>$now->dayOfWeek, "clients"=>$clients,"operators"=>$operators,"menu"=>$menu,]);
        }else{
            return redirect('/');
        }
    }

    public function data_weekly($id){
        $days=[];
        $data  = ScheduleDetailModel::select( "detail_schedule_user.id as id", "detail_schedule_user.type_daily as type", "inf.name as name", "inf.last_name as lastname","cli.name as client","ccl.hex as color",'set.name as setting','detail_schedule_user.time_start as time_s','detail_schedule_user.time_end as time_e',"detail_schedule_user.status as status")
                     ->join('schedule as sch','sch.id', "=", 'detail_schedule_user.id_schedule')
                    ->join('clients as cli', 'cli.id',"=","sch.id_client")
                    ->join('client_color as ccl', 'ccl.id',"=","cli.color")
                    ->join('users_info as inf','inf.id_user', "=", 'detail_schedule_user.id_operator')
                    ->join('settings as set','set.id','=','detail_schedule_user.option')
                    ->where('detail_schedule_user.id',$id)
                    ->first();

        $daysN = DayOffModel::select('id_day')
        ->where("id_schedule",$data->id_schedule)
        ->get();

        foreach($daysN as $day){
                array_push($days,$day->id_day);
            } 

        $data2=[ "detail"=>$data, "days"=>$days,];

        return $data2;
    }

    public function data_dayoff(Request $request){
        if($request->date !=""){
            $now =Carbon::parse($request->date);

            $data2 = ScheduleDetailModel::select( "detail_schedule_user.id as id", "detail_schedule_user.type_daily as type", "inf.name as name", "inf.last_name as lastname","cli.name as client","ccl.hex as color",'detail_schedule_user.time_start as time_s','detail_schedule_user.time_end as time_e',"detail_schedule_user.status as status")
            ->join('schedule as sch','sch.id', "=", 'detail_schedule_user.id_schedule')
            ->join('clients as cli', 'cli.id',"=","sch.id_client")
            ->join('client_color as ccl', 'ccl.id',"=","cli.color")
            ->join('users_info as inf','inf.id_user', "=", 'detail_schedule_user.id_operator')
            ->where('sch.week',"=", $now->weekOfYear)
            ->where('sch.month',"=", $now->month)
            ->where('sch.year',"=", $now->year)
            ->where('detail_schedule_user.status',2)
            ->where('detail_schedule_user.id_day',"=", $now->dayOfWeek);
            
            if($request->operator != "all"){
                $data2->where('detail_schedule_user.id_operator',"=", $request->operator);
            }
            if($request->client != "all"){
                $data2->where('sch.id_client',"=", $request->client);
            }
            $day = DaysModel::where('id',$now->dayOfWeek)->first();
        } else{
            $now = Carbon::now();
            $data2 = ScheduleDetailModel::select( "detail_schedule_user.id as id", "detail_schedule_user.type_daily as type", "inf.name as name", "inf.last_name as lastname","cli.name as client","ccl.hex as color",'day.Eng-name as day','detail_schedule_user.time_start as time_s','detail_schedule_user.time_end as time_e',"detail_schedule_user.status as status")
            ->join('schedule as sch','sch.id', "=", 'detail_schedule_user.id_schedule')
            ->join('clients as cli', 'cli.id',"=","sch.id_client")
            ->join('client_color as ccl', 'ccl.id',"=","cli.color")
            ->join('users_info as inf','inf.id_user', "=", 'detail_schedule_user.id_operator')
            ->join('days as day','day.id', "=", 'detail_schedule_user.id_day')
            ->where('detail_schedule_user.id_day',"=", $now->dayOfWeek)
            ->where('sch.week',"=", $now->weekOfYear)
            ->where('sch.month',"=", $now->month)
            ->where('sch.year',"=", $now->year)
            ->where('detail_schedule_user.status',2);
            $day = DaysModel::where('id',$now->dayOfWeek)->first();
        } 
        $data=$data2->get();

        return response()->json(["dayoff"=>$data,"day"=>$day]);
    }

    public function data_break(Request $request){
     
    }
    public function validateDailyChange($request){
        
            $this->validate(request(), [
                'option' => 'required',
            ]); 
    }
  
  
    public function show($weekly_id)
    {
        $weekly =  ScheduleDetailModel::select('id','option')->where('id',$weekly_id)->first();
        $data=['No'=>2,'wd'=>$weekly];
        return response()->json($data);
    }

    public function update(Request $request, $weekly_id)
    {
            ScheduleDailyController::validateDailyChange($request);
            $weekly = ScheduleDetailModel::find($weekly_id);
            $weekly->option = $request->option;
            $weekly->save();
            $weeklyData = ScheduleDailyController::data_weekly($weekly_id);
           
            $data=['No'=>2,'wd'=>$weeklyData,'ed'=>0, "color"=>2];
            return response()->json($data);
    }

}
