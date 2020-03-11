<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SettingsModel;
use Illuminate\Support\Facades\Auth;
use App\OptionsSettingModel;
use App\DaysModel;
use App\User;
use App\User_info;
use App\TypeUserModel;
use App\ClientModel;
use App\TorCDuration;
use App\ScheduleTrainingModel;
use App\TrainingDetailModel;
use Illuminate\Support\Facades\Hash;


use Carbon\Carbon;


class TrainingController extends Controller
{
  
    public function index(Request $request)
    {          
        $user = Auth::user();
        $id_menu=5;
        $menu = menu($user,$id_menu);
        
        if($menu['validate']){  
            $days= DaysModel::all();

            if($request->date !=""){
                if(strlen($request->type) > 0 &&  strlen($search) > 0){
                    $now =Carbon::parse($request->date);
                   

                     $type= SettingsController::search_settings($request->type);

                    $data2 =  SettingsModel::select('settings.id as id','op.option as option','settings.name as name', 'settings.status as status')
                            ->join('options_settings as op', 'op.id', '=', 'settings.id_option')
                            ->whereNotIn('settings.status',[0])->where($type,'LIKE','%'.$search.'%')->paginate(5);
                    // $data2 = SettingsModel::whereNotIn('status',[0])->where($request->type,'LIKE','%'.$search.'%')->paginate(5);
                } else{
                    $now = Carbon::now();
                    $data2 =  SettingsModel::select('settings.id as id','op.option as option','settings.name as name', 'settings.status as status')
                    ->join('options_settings as op', 'op.id', '=', 'settings.id_option')
                    ->whereNotIn('settings.status',[0])->paginate(5);
                } 

                // return view('training.index',["data"=>$data,"menu"=>$menu,"options_settings"=>$options,"days"=>$days,"today"=>$now->toDateString(),"NoD"=>$now->dayOfWeek,]);


            }else{
                if(strlen($request->type) > 0 &&  strlen($search) > 0){
                    $now = Carbon::now();
                     $type= SettingsController::search_settings($request->type);

                    $data2 =  SettingsModel::select('settings.id as id','op.option as option','settings.name as name', 'settings.status as status')
                            ->join('options_settings as op', 'op.id', '=', 'settings.id_option')
                            ->whereNotIn('settings.status',[0])->where($type,'LIKE','%'.$search.'%')->paginate(5);
                    // $data2 = SettingsModel::whereNotIn('status',[0])->where($request->type,'LIKE','%'.$search.'%')->paginate(5);
                } else{
                    $now = Carbon::now();
                    $data2 =  SettingsModel::select('settings.id as id','op.option as option','settings.name as name', 'settings.status as status')
                    ->join('options_settings as op', 'op.id', '=', 'settings.id_option')
                    ->whereNotIn('settings.status',[0])->paginate(5);
                } 

            }
            // $data=$data2;
            // if ($request->ajax()) {
            //     return view('training.table', ["data"=>$data]);
            // }
            // $options= OptionsSettingModel::all();
            //     // return view('training.index',["data"=>$data,"menu"=>$menu,"options_settings"=>$options,"days"=>$days,"today"=>$now->toDateString(),"NoD"=>$now->dayOfWeek,]);

                if($request->date !=""){
                    $now =Carbon::parse($request->date);
                    $fecha= $now->dayOfWeek;
                    print_r($fecha);
                    $data=$data2;
                    if ($request->ajax()) {
                        return view('training.table', ["data"=>$data]);
                    }
                    $options= OptionsSettingModel::all();
                    $trainers = User::where('id_type_user', 3)->with('User_info')->get();
                    $clients = ClientModel::all();


                        return view('training.index',["data"=>$data,"menu"=>$menu,"options_settings"=>$options,"days"=>$days,"today"=>$now->toDateString(),"NoD"=>$fecha,'trainers'=>$trainers, 'clients'=>$clients]);
        
                }else{
                    $now =Carbon::now();
                    $fecha= $now->dayOfWeek;
                    print_r($fecha);
                    $data=$data2;
                    if ($request->ajax()) {
                        return view('training.table', ["data"=>$data]);
                    }
                    $options= OptionsSettingModel::all();
                    $trainers = User::where('id_type_user', 3)->with('User_info')->get();
                    $clients = ClientModel::all();

                        return view('training.index',["data"=>$data,"menu"=>$menu,"options_settings"=>$options,"days"=>$days,"today"=>$now->toDateString(),"NoD"=>$fecha,'trainers'=>$trainers, 'clients'=>$clients]);
        
                }









        //     $search = trim($request->dato);

        //         if(strlen($request->type) > 0 &&  strlen($search) > 0){
        //             $now = Carbon::now();
        //              $type= SettingsController::search_settings($request->type);

        //             $data2 =  SettingsModel::select('settings.id as id','op.option as option','settings.name as name', 'settings.status as status')
        //                     ->join('options_settings as op', 'op.id', '=', 'settings.id_option')
        //                     ->whereNotIn('settings.status',[0])->where($type,'LIKE','%'.$search.'%')->paginate(5);
        //             // $data2 = SettingsModel::whereNotIn('status',[0])->where($request->type,'LIKE','%'.$search.'%')->paginate(5);
        //         } else{
        //             $now = Carbon::now();
        //             $data2 =  SettingsModel::select('settings.id as id','op.option as option','settings.name as name', 'settings.status as status')
        //             ->join('options_settings as op', 'op.id', '=', 'settings.id_option')
        //             ->whereNotIn('settings.status',[0])->paginate(5);
        //         } 
        //         $data=$data2;
        //         if ($request->ajax()) {
        //             return view('training.table', ["data"=>$data]);
        //         }
        //         $options= OptionsSettingModel::all();
        //         print_r($request->date);
        // return view('training.index',["data"=>$data,"menu"=>$menu,"options_settings"=>$options,"days"=>$days,"today"=>$now->toDateString(),"NoD"=>$now->dayOfWeek,]);
         }else{
            return redirect('/');
         }
            
    }

    public function data_settings($id){
        $data2 =  SettingsModel::select('settings.id as id','op.id as id_option','op.option as option','settings.name as name', 'settings.status as status')
        ->join('options_settings as op', 'op.id', '=', 'settings.id_option')
        ->where('settings.id',$id)->first();

        return $data2;
    }

    public function validateSettings($request,$setting_id){
        if($setting_id==""){
        $this->validate(request(), [
            'name' => 'required|max:30',
            'id_option' => 'required',

        ]); 
        }else{
            $this->validate(request(), [
                'name' => 'required|max:30',
                'id_option' => 'required',
            ]);   
        }
    }

    public function generateEnd_training(Request $request)
    { 
        $num=0;

        if ($request->start_training!=null && $request->end_training!=null) {
            $end_training=$request->end_training;
            $end_training2=$request->end_training;
            $start=$request->start_training;
            $start2=$request->start_training;

            $start3=Carbon::parse($start2);
            $end=Carbon::parse($end_training2);

            $weeks= $end->weekOfYear - $start3->weekOfYear;
            $weeks+=1;
            $num=['num'=>$weeks, 'flag'=>1];

        }elseif ($request->start_training!=null && $request->numWeek > 0) {
            $date=Carbon::parse($request->start_training);
            $date2=Carbon::parse($request->start_training);
            $start=$date->startOfWeek(Carbon::SUNDAY);
            $start2=$date->startOfWeek(Carbon::SUNDAY);
            $end=$date2->endOfWeek(Carbon::SATURDAY);
            $fin=$start2->addWeek($request->numWeek);
            $end_training=$fin->subDay(1)->format('Y-m-d');
            $num=['num'=>$request->numWeek, 'flag'=>2];
        }
        return response()->json(['start_training'=>$request->start_training, 'end_training'=>$end_training,'num'=>$num]);
    }

    public function store(Request $request)
    {     
        //in TorCDuration
        //type=1 está en training , type=2 está en coaching
    //--------------------------//
    //in ScheduleModel
        //status=1 horario habilitado, status=2 el horario todavia no se usa porque está en coaching
    //--------------------------//
        
        $correo=$request->email.'@yasemail.com';
        // $user =  User::Create([
        //     'id_type_user'=>11,
        //     'id_status'=>1,
        //     'nickname'=>"",
        //     'email'=>$correo,
        //     'password'=>Hash::make('123'),
        // ]);

        // $User_info =  User_info::Create([
        //     'id_user'=>$user->id,
        //     'name'=>$request->name,
        //     'last_name'=>$request->last_name,
        //     'address'=>'',
        //     'phone'=>$request->phone,
        //     'emergency_contact_name'=>$request->emergency_contact_name,
        //     'emergency_contact_phone'=>$request->emergency_contact_phone,
        //     'notes'=>$request->notes,
        //     'description'=>$request->description,
        //     'gender'=>$request->gender,
        //     'birthdate'=>$request->birthdate,
        //     'profile_picture'=>"",
        //     'biotime_status'=>"",
        //     'access_code'=>"",
        //     'entrance_date'=>"2020-01-01",
        // ]);
            $schedulearray=[];
        if ($request->end_coaching!= null) {
            $start_coaching=Carbon::parse($request->end_training)->addDay(1);

            $id_training =  TorCDuration::Create([
                'mat'=>'TCD',
                'id_trainer'=>$request->id_trainer,
                'date_start'=> $request->start_training,
                'date_end'=> $request->end_training,
                'type'=>1 ,
                'status'=>1 ,
            ]);
            array_push($schedulearray, array('id'=>$id_training->id,'status'=>1));

            $id_coaching =  TorCDuration::Create([
                'mat'=>'TCD',
                'id_trainer'=>$request->id_trainer,
                'date_start'=> $start_coaching,
                'date_end'=> $request->end_coaching,
                'type'=>2 ,
                'status'=>1 ,
            ]);
            array_push($schedulearray, array('id'=>$id_coaching->id,'status'=>2));

        }else{
            $id_training =  TorCDuration::Create([
                'mat'=>'TCD',
                'id_trainer'=>$request->id_trainer,
                'date_start'=> $request->start_training,
                'date_end'=> $request->end_training,
                'type'=>1 ,
                'status'=>1 ,
            ]);
            array_push($schedulearray, array('id'=>$id_training->id,'status'=>1));
        }
        $length_array=count($schedulearray);

        for ($i=0; $i < $length_array; $i++) { 
                $start_week='';
                $start_training=Carbon::parse($request->start_training);
                $day_start=$start_training->dayOfWeek;
                $day_end=Carbon::parse($request->end_training)->dayOfWeek;
                $start_week=Carbon::parse($request->start_training)->startOfWeek(Carbon::SUNDAY);
                $end_week=Carbon::parse($request->start_training)->endOfWeek(Carbon::SATURDAY);

            for ($j=0; $j < $request->numWeek; $j++) { 
            

                $weekYears=$end_week->weekOfYear;

                $month_I=Carbon::parse($start_week)->month;
                $month_F=Carbon::parse($end_week)->month;

                $year=Carbon::parse($start_week)->year;
                $type='';
                if ($schedulearray[$i]['status']==1) {
                    $type=2;
                }else{
                    $type=3;
                }
                $schedule =  ScheduleTrainingModel::Create([
                    'id_operator'=>3,
                    'id_torcduration'=> $schedulearray[$i]['id'] ,
                    // 'id_operator'=>$user->id,
                    'id_client'=>$request->id_client ,
                    'mat'=>'SCH',
                    'date_start'=>$start_week ,
                    'date_end'=> $end_week,
                    'type_schedule'=>$type ,
                    'week'=> $weekYears,
                    'month'=>$month_I ,
                    'year'=>$year,
                    'status'=> 1 ,
            
                ]);
                for ($k=0; $k <7 ; $k++) { 
                    $training_detail =  TrainingDetailModel::Create([
                    'mat'=>'TSD' ,
                    'id_user'=> 3,
                    'id_schedule'=>$schedule->id,
                    'id_day'=>$k ,
                    'start_time'=>$request->start ,
                    'end_time'=>$request->end ,
                    'options'=>0 ,
                    'status'=>1 ,
                        ]);
                }
               
                $start_week->addWeek();
                $end_week->addWeek();
            }
                $Schedule_id_start=ScheduleTrainingModel::where('date_start','<=',$request->start_training)
                ->where('date_end','>=',$request->start_training)
                ->first();
                $NDay_start=TrainingDetailModel::where('id_schedule',$Schedule_id_start->id)->where('id_day','<',$day_start)->delete();

                $Schedule_id_end=ScheduleTrainingModel::where('date_end','>=',$request->end_training)->where('id_torcduration', $schedulearray[$i]['id'] )
                ->first();
                $NDay_end=TrainingDetailModel::where('id_schedule',$Schedule_id_end->id)->where('id_day','>',$day_end)->delete();

            
            
        }

        // $daysOFF =  DayOffModel::Create([
        //     'id_schedule'=>$schedule->id,
        //     // 'id_day'=>,
        // ]);

        // $mirror_userScheduleDetail =  MirrorUserScheduleDetailModel::Create([
        //     'id_schedule'=>$schedule->id,
        //     'id_operator'=> $user->id,
        //     // 'id_day'=> ,
        //     // 'mat'=> ,
        //     // 'time_start'=> ,
        //     // 'time_end'=> ,
        //     // 'type_daily'=> ,
        //     // 'option'=> ,
        //     // 'status'=> ,
        // ]);

        // $result = TrainingController::getResult($user->id);

        // return response()->json($result);

      
           
    }

    public function show($settings_id)
    {

        $dataSettings= SettingsController::data_settings($settings_id);
        $dataSettings->status=1;
        return response()->json($dataSettings);
    }

    public function validateSettingsExists($name, $id_option){
        $settingValidation = SettingsModel::where('name',$name)
        ->where('id_option', $id_option)
        ->whereIn('status', [1,2])
        ->exists();
        return $settingValidation;
    }

    public function update(Request $request, $settings_id)
    {
        // // $settingValidation = SettingsController::validateSettingsExists($request->name,$request->id_option);
        // if(!$settingValidation){
        //     // SettingsController::validateSettings($request,$settings_id);
        //     $setting = SettingsModel::find($settings_id);
        //     $setting->name = $request->name;
        //     $setting->id_option = $request->id_option;
        //     $setting->status=1;
        //     $setting->save();
        //     $dataSettings= SettingsController::data_settings($setting->id);

        //     return response()->json($dataSettings);
        // }else{
        //     $msg='Another option already has that name and that type';
        //     $data=['No'=>1,'msg'=>$msg];
        //     return response()->json($data);
        // }
    }

    public function destroy($settings_id)
    {
        $setting = SettingsModel::find($settings_id);
        if($setting->status == 2)
        {
            $setting->status = 1;
        }
        else
        {
            $setting->status = 2;  
        }
        $setting->save();
        $dataSettings= SettingsController::data_settings($setting->id);

        return response()->json($dataSettings);
    } 
    public function delete($settings_id)
    {
        $setting = SettingsModel::find($settings_id);
            $setting->status = 0;
            $setting->save();
        return response()->json($setting);
    } 
}
