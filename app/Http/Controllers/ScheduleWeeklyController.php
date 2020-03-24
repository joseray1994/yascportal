<?php

namespace App\Http\Controllers;
use App\User;
use App\Audit;
use App\SettingsModel;
use App\SuspendedModel;
use Illuminate\Http\Request;
use App\ScheduleDetailModel;
use App\DaysModel;
use App\ClientModel;
use App\DayOffModel;
use App\ScheduleModel;
use App\AssignamentTypeModel;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Auth;

class ScheduleWeeklyController extends Controller
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
            
              
                $days= DaysModel::all();
                $operators=User::select('users.id as id', 'ui.name as name', 'ui.last_name as lname')
                ->join('users_info as ui', 'ui.id_user', '=', 'users.id')
                ->where('users.id_type_user','=',9)
                ->get();
                $clients=ClientModel::all();
                $settings= SettingsModel::all();
                if($request->date !=""){
                    $now =Carbon::parse($request->date);

                    $data2 = ScheduleDetailModel::select( "detail_schedule_user.id as id", "detail_schedule_user.type_daily as type", "inf.name as name", "inf.last_name as lastname","cli.name as client","ccl.hex as color",'day.Eng-name as day','detail_schedule_user.time_start as time_s','detail_schedule_user.time_end as time_e',"detail_schedule_user.status as status")
                    ->join('schedule as sch','sch.id', "=", 'detail_schedule_user.id_schedule')
                    ->join('clients as cli', 'cli.id',"=","sch.id_client")
                    ->join('client_color as ccl', 'ccl.id',"=","cli.color")
                    ->join('users_info as inf','inf.id_user', "=", 'detail_schedule_user.id_operator')
                    ->join('days as day','day.id', "=", 'detail_schedule_user.id_day')
                    ->where('sch.week',"=", $now->weekOfYear)
                    ->where('sch.month',"=", $now->month)
                    ->where('sch.year',"=", $now->year)
                    ->whereIn('sch.status',[1,2])
                    ->whereIn('detail_schedule_user.status',[1,2,3]);

                    if($request->day != "allDays"){
                        $data2->where('detail_schedule_user.id_day',"=", $request->day);
                    }
                    if($request->operator != "allOperators"){
                        $data2->where('detail_schedule_user.id_operator',"=", $request->operator);
                    }
                    if($request->client != "allClients"){
                        $data2->where('sch.id_client',"=", $request->client);
                    }
                    if($request->work != "allWorks"){
                        $data2->where('detail_schedule_user.type_daily',"=", $request->work);
                    }

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
                    ->whereIn('sch.status',[1,2])
                    ->whereIn('detail_schedule_user.status',[1,2,3]);
                    
                } 
                $data=$data2->orderBy('detail_schedule_user.id_day')->paginate(100);
                if ($request->ajax()) {
                    return view('schedule.weekly.table', ["data"=>$data]);
                }
            
        return view('schedule.weekly.index',["data"=>$data,"days"=>$days,"settings"=>$settings,"today"=>$now->toDateString(),"NoD"=>$now->dayOfWeek, "clients"=>$clients,"operators"=>$operators,"menu"=>$menu,]);
        }else{
            return redirect('/');
        }
    }

    public function data_weekly($id){
        $days=[];
        $data = ScheduleDetailModel::select( "detail_schedule_user.id as id",'set.name as setting',"detail_schedule_user.id_schedule as id_schedule", "detail_schedule_user.type_daily as type", "inf.name as name", "inf.last_name as lastname","cli.name as client","ccl.hex as color",'day.Eng-name as day','detail_schedule_user.time_start as time_s','detail_schedule_user.time_end as time_e',"detail_schedule_user.hours as hours","detail_schedule_user.minutes as minutes","detail_schedule_user.status as status")
                    ->join('schedule as sch','sch.id', "=", 'detail_schedule_user.id_schedule')
                    ->join('clients as cli', 'cli.id',"=","sch.id_client")
                    ->join('client_color as ccl', 'ccl.id',"=","cli.color")
                    ->join('users_info as inf','inf.id_user', "=", 'detail_schedule_user.id_operator')
                    ->join('days as day','day.id', "=", 'detail_schedule_user.id_day')
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

    public function validateExistSchedule($request,$weekly){
        $check=0; 
        
        //validation of normalshift 
        if($weekly->status == 1){
            if($request->time_start > $request->time_end){
            
                $valStart=ScheduleDetailModel::where('id','!=',$weekly->id)->where('id_day',$weekly->id_day)->where('time_start','>=',$request->time_start)->where('time_start','<=',"23:59:59")->where('status',1)->count();
                $valMs=ScheduleDetailModel::where('id','!=',$weekly->id)->where('id_day',$weekly->id_day)->where('time_start','>=',"00:00:00")->where('time_start','<=',$request->time_end)->where('status',1)->count();
                $valMe=ScheduleDetailModel::where('id','!=',$weekly->id)->where('id_day',$weekly->id_day)->where('time_end','>=',$request->time_start)->where('time_end','<=',"23:59:59")->where('status',1)->count();
                $valEnd=ScheduleDetailModel::where('id','!=',$weekly->id)->where('id_day',$weekly->id_day)->where('time_end','>=',"00:00:00")->where('time_end','<=',$request->time_end)->where('status',1)->count();

            }else if($request->time_end > $request->time_start){
            
                $valStart=ScheduleDetailModel::where('id','!=',$weekly->id)->where('id_day',$weekly->id_day)->where('time_start','>=',$request->time_start)->where('time_start','<=',$request->time_end)->where('status',1)->count();
                $valEnd=ScheduleDetailModel::where('id','!=',$weekly->id)->where('id_day',$weekly->id_day)->where('time_end','>=',$request->time_start)->where('time_end','<=',$request->time_end)->where('status',1)->count();
                $valMs=0;
                $valMe=0;
            }
           
            if($valEnd > 0 || $valStart > 0||$valMs>0 ||$valMe>0){
                $check += 1 ; 
            }
        }

       //validation of extrahuors 
        if($request->time_extra && $request->time_endEx){

            if($request->time_extra > $request->time_endEx){
                
                $valStartex=ScheduleDetailModel::where('id','!=',$weekly->id)->where('id_day',$weekly->id_day)->where('time_start','>=',$request->time_extra)->where('time_start','<=',"23:59:59")->where('status',1)->count();
                $valMsex=ScheduleDetailModel::where('id','!=',$weekly->id)->where('id_day',$weekly->id_day)->where('time_start','>=',"00:00:00")->where('time_start','<=',$request->time_endEx)->where('status',1)->count();
                $valMeex=ScheduleDetailModel::where('id','!=',$weekly->id)->where('id_day',$weekly->id_day)->where('time_end','>=',$request->time_extra)->where('time_end','<=',"23:59:59")->where('status',1)->count();
                $valEndex=ScheduleDetailModel::where('id','!=',$weekly->id)->where('id_day',$weekly->id_day)->where('time_end','>=',"00:00:00")->where('time_end','<=',$request->time_endEx)->where('status',1)->count();
            
            }else if($request->time_endEx > $request->time_extra){

                $valStartex=ScheduleDetailModel::where('id','!=',$weekly->id)->where('id_day',$weekly->id_day)->where('time_start','>=',$request->time_extra)->where('time_start','<=',$request->time_endEx)->where('status',1)->count();
                $valEndex=ScheduleDetailModel::where('id','!=',$weekly->id)->where('id_day',$weekly->id_day)->where('time_end','>=',$request->time_extra)->where('time_end','<=',$request->time_endEx)->where('status',1)->count();
                $valMeex = 0;
                $valMsex = 0;

            }

            
            if($valEndex > 0 || $valStartex > 0||$valMsex>0 ||$valMeex>0){
                $check += 1 ; 
            }
        }

        
        return $check;
    }
    public function validateSchedule($request){
        
            $this->validate(request(), [
                'time_start' => 'required',
                'time_end' => 'required',
                'time_extra' => 'sometimes|nullable',
                'time_endEx' => 'sometimes|nullable',
                'hours' => 'sometimes|nullable|numeric|max:24|min:0',
                'minutes' => 'sometimes|nullable|numeric|max:59|min:0',
            ]); 
    }

    public function validateScheduleExtra($request,$weekly_id =""){
        
        $this->validate(request(), [
            'time_start' => 'required',
            'time_end' => 'required',
            'hours' => 'required|numeric|max:24|min:0',
            'minutes' => 'required|numeric|max:59|min:0',
        ]); 
}
  
    /**
     * Functions for create and Update schedule data .
     *
     * @return \Illuminate\Http\Response
     */
    public function CreateExtraShift($request,$weekly){
        $w=0;
        if($request->hours >0 || $request->minutes >0 ){
           
            $extra=ScheduleDetailModel::Create([
                    "id_schedule"=>$weekly->id_schedule,
                    "id_operator"=>$weekly->id_operator,
                    "id_day"=>$weekly->id_day,
                    "time_start"=>$request->time_extra,
                    "time_end"=>$request->time_endEx,
                    "hours"=>$request->hours,
                    "minutes"=>$request->minutes,
                    "type_daily"=>4,
                    "option"=>1,
                    "status"=>1,
                ]);
        $w = ScheduleWeeklyController::data_weekly($extra->id);   
        }
        return $w;
   }
   
    public function store(Request $request,$weekly_id)
    {      

                ScheduleWeeklyController::validateScheduleExtra($request);
                $weekly = ScheduleDetailModel::find($weekly_id);
                if(ScheduleWeeklyController::validateExistSchedule($request,$weekly) == 0){
                $weekly->time_start = $request->time_start;
                $weekly->time_end = $request->time_end;
                $weekly->hours = $request->hours;
                $weekly->minutes = $request->minutes;
                $weekly->status=1;
                $weekly->save();

                $weeklyData = ScheduleWeeklyController::data_weekly($weekly_id);
                $data=['No'=>1,'ed'=>$weeklyData];

                }else{
                    $data=['No'=>3,'msg'=>"The schedule is already in use or one of the hours is between some other schedule"];
                }
                
                return response()->json($data);
      
           
    }
  
    public function show($weekly_id)
    {

        $weekly = ScheduleWeeklyController::data_weekly($weekly_id);
        $data=['No'=>1,'wd'=>$weekly];
        return response()->json($data);
    }
    public function audit_data($id,$request){
            $weekly = ScheduleDetailModel::find($id);
            $audits = Audit::select('audits.id as id','audits.old_values as old','audits.new_values as new','audits.created_at as created','audits.event as event','inf.name as name','inf.last_name as lname')
            ->join('users_info as inf','inf.id_user', "=", 'audits.user_id')
            ->where('audits.user_id',$weekly->id_operator)
            ->where('audits.auditable_type','App\ScheduleDetailModel')
            ->where('audits.auditable_id',$id);

            if($request->date != ""){
                $audits->whereDate('audits.created_at',$request->date);   
                }
            if($request->time != ""){
                $audits->whereTime('audits.created_at', '>=', $request->time);
            }

            $audit= $audits->get();

            $data=['No'=>2,'audit'=>$audit];
            return $data;
    }

    public function suspended_data($id){
        $weekly = ScheduleDetailModel::find($id);
        $suspended = SuspendedModel::select('schedule_suspended.id as id','schedule_suspended.date_start as dateS','schedule_suspended.date_end as dateE','schedule_suspended.created_at as created','schedule_suspended.status as status','inf.name as name','inf.last_name as lname')
        ->join('users_info as inf','inf.id_user', "=", 'schedule_suspended.id_operator')
        ->where('schedule_suspended.id_operator',$weekly->id_operator)
        ->whereIn('schedule_suspended.status',[1,2])
        ->get();
      
        $data=['No'=>1,'suspended'=>$suspended, 'operator'=>$weekly->id_operator];
        return $data;
    }


    public function detail(Request $request, $weekly_id)
    {   
        if($request->action == 1){

            $data = ScheduleWeeklyController::suspended_data($weekly_id);

        }else if($request->action == 2){

            $data = ScheduleWeeklyController::audit_data($weekly_id,$request);

        }else{
            $data=['No'=>3,'error'=>"Request Error, Try again"];
        }
        
        return response()->json($data);
    }

    public function update(Request $request, $weekly_id)
    {
           function UpdateDayOff($weekly,$request){
                $res=0;
                DayOffModel::where("id_schedule",$weekly->id_schedule)->truncate();

               if(!empty($request->days))
               {
                foreach($request->days as $days){
                    DayOffModel::Create([
                        "id_schedule"=>$weekly->id_schedule,
                        "id_day"=>$days,
                        ]);
                    }
        
                $data = ScheduleDetailModel::whereIn('id_day',$request->days)
                        ->where('id_schedule',$weekly->id_schedule)
                        ->where('type_daily', 1)
                        ->update(['status' => 2]);

                $data2 = ScheduleDetailModel::whereNotIn('id_day',$request->days)
                        ->where('id_schedule',$weekly->id_schedule)
                        ->where('type_daily', 1)
                        ->update(['status' => 1]);
                
                $res+=1;
               }
               return $res; 
           }
           
           function UpdateAllWeekly($weekly,$request){
            $res=0;
            if($request->now == "now"){
                
                $data2 = ScheduleDetailModel::where('id_day','>',$weekly->id_day)
                            ->where('id_schedule',$weekly->id_schedule)
                            ->where('type_daily', 1)
                            ->update(['time_start' => $request->time_start, 'time_end'=>$request->time_end]);

                $res+=1;
              } 

              if($request->today == "ev"){
                $data2 = ScheduleDetailModel::where('id_schedule',$weekly->id_schedule)
                ->where('type_daily', 1)
                ->update(['time_start' => $request->time_start, 'time_end'=>$request->time_end]);
                $res+=1;
              } 

              return $res; 
           }
         
          
            $weekly = ScheduleDetailModel::find($weekly_id);
            ScheduleWeeklyController::validateSchedule($request);
            
            if(ScheduleWeeklyController::validateExistSchedule($request,$weekly) == 0){
                $weekly->time_start = $request->time_start;
                $weekly->time_end = $request->time_end;
                $weekly->save();

                $updayoff = UpdateDayoff($weekly,$request);
                $upweek=UpdateAllWeekly($weekly,$request);

                $extradata=ScheduleWeeklyController::CreateExtraShift($request,$weekly);
                $weeklyData = ScheduleWeeklyController::data_weekly($weekly_id);
                    
                $data=['No'=>2,'wd'=>$weeklyData, 'ed'=>$extradata];

            }else{
                $data=['No'=>3,'msg'=>"The user has already assigned a schedule in the time range."];
            }
            return response()->json($data);
    }

    public function delete($weekly_id)
    {
        $weekly = ScheduleDetailModel::find($weekly_id);
            $weekly->status = 0;
            $weekly->save();

            $data=['No'=>1,'wd'=>$weekly];

        return response()->json($data);
    } 


    public function quit($weekly_id)
    {
        $weekly = ScheduleDetailModel::find($weekly_id);
        $schedule = ScheduleModel::where('id_operator',$weekly->id_operator)
                                     ->update(['status' => 2]);
      
        $detail_sch = ScheduleDetailModel::where('id_operator',$weekly->id_operator)
                                     ->update(['status' => 3]);

        $weeklyData = ScheduleWeeklyController::data_weekly($weekly_id);

        $data=['No'=>3,'quit'=>$weeklyDat];
        return response()->json($data);
    } 


    public function suspended_create($weekly_id)
    {
        $weekly = ScheduleDetailModel::find($weekly_id);

        $schedule = ScheduleModel::where('id_operator',$weekly->id_operator)
                                     ->update(['status' => 3]);
      
        $detail_sch = ScheduleDetailModel::where('id_operator',$weekly->id_operator)
                                     ->update(['status' => 4]);

        
        
        $weeklyData = ScheduleWeeklyController::data_weekly($weekly_id);

    
        return response()->json($weeklyData);
    } 
    
    public function auditdetail($id){
        $audit = Audit::select('audits.auditable_id as id','audits.old_values as old','audits.new_values as new','inf.name as name','inf.last_name as lname')
            ->join('users_info as inf','inf.id_user', "=", 'audits.user_id')
            ->where('audits.id',$id)
            ->first();

            $data=['No'=>3,'audit'=>$audit];
        return response()->json($data);
    }

}
