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
use App\MirrorUserScheduleDetailModel;
use App\DayOffModel;
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

    public function generateEnd_coaching(Request $request)
    { 
        $num=0;

        if ($request->end_training!=null && $request->end_coaching!=null) {
            $end_coaching=$request->end_coaching;
            $end_coaching2=$request->end_coaching;
            $start=$request->end_training;
            $start2=$request->end_training;

            $start3=Carbon::parse($start2);
            $end=Carbon::parse($end_coaching2);

            $weeks= $end->weekOfYear - $start3->weekOfYear;
            $weeks+=1;
            $num=['num'=>$weeks, 'flag'=>1];

        }
        // elseif ($request->start_training!=null && $request->numWeek > 0) {
        //     $date=Carbon::parse($request->start_training);
        //     $date2=Carbon::parse($request->start_training);
        //     $start=$date->startOfWeek(Carbon::SUNDAY);
        //     $start2=$date->startOfWeek(Carbon::SUNDAY);
        //     $end=$date2->endOfWeek(Carbon::SATURDAY);
        //     $fin=$start2->addWeek($request->numWeek);
        //     $end_training=$fin->subDay(1)->format('Y-m-d');
        //     $num=['num'=>$request->numWeek, 'flag'=>2];
        // }
        return response()->json(['num'=>$num]);
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
        //crea usuario
        $user =  User::Create([
            'id_type_user'=>11,
            'id_status'=>1,
            'nickname'=>"",
            'email'=>$correo,
            'password'=>Hash::make('123'),
        ]);
            //crea la informacion del usuario
        $User_info =  User_info::Create([
            'id_user'=>$user->id,
            'name'=>$request->name,
            'last_name'=>$request->last_name,
            'address'=>'',
            'phone'=>$request->phone,
            'emergency_contact_name'=>$request->emergency_contact_name,
            'emergency_contact_phone'=>$request->emergency_contact_phone,
            'notes'=>$request->notes,
            'description'=>$request->description,
            'gender'=>$request->gender,
            'birthdate'=>$request->birthdate,
            'profile_picture'=>"",
            'biotime_status'=>"",
            'access_code'=>"",
            'entrance_date'=>"2020-01-01",
        ]);
    //inserta en la tabla espejo el horario que tendrá el trainee cuando sea el operador
        $horario=[];
        array_push($horario, array('start'=>$request->start_monday,'end'=>$request->end_monday));
        array_push($horario, array('start'=>$request->start_tuesday,'end'=>$request->end_tuesday));
        array_push($horario, array('start'=>$request->start_wednesday,'end'=>$request->end_wednesday));
        array_push($horario, array('start'=>$request->start_thursday,'end'=>$request->end_thursday));
        array_push($horario, array('start'=>$request->start_friday,'end'=>$request->end_friday));
        array_push($horario, array('start'=>$request->start_saturday,'end'=>$request->end_saturday));
        array_push($horario, array('start'=>$request->start_sunday,'end'=>$request->end_sunday));
        $days=DaysModel::all();
            for ($i=0 ; $i < count($horario); $i++ ) { 
                $daysOff=$request->id_dayOff_O;
                $status_dayoff=1;
                foreach ($daysOff as $dayOff) {
                    if ($i==$dayOff) {
                        $status_dayoff=2;
                    }
                    
                }
                $mirror_userScheduleDetail =  MirrorUserScheduleDetailModel::Create([
                    'id_schedule'=>0,
                    'id_operator'=>$user->id,
                    'id_day'=> $i,
                    'mat'=>'MSD' ,
                    'time_start'=>$horario[$i]['start'] ,
                    'time_end'=>$horario[$i]['end'] ,
                    'type'=> 0,
                    'option'=> 0,
                    'status'=> $status_dayoff,
                ]);
            }
    //-------------------------------------------
    //se valida si tendrá solo training o training y coaching
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
            array_push($schedulearray, array('id'=>$id_training->id,'status'=>1, 'isTraining'=>true));

            $id_coaching =  TorCDuration::Create([
                'mat'=>'TCD',
                'id_trainer'=>$request->id_trainer,
                'date_start'=> $start_coaching,
                'date_end'=> $request->end_coaching,
                'type'=>2 ,
                'status'=>1 ,
            ]);
            array_push($schedulearray, array('id'=>$id_coaching->id,'status'=>2, 'isTraining'=>false), );

        }else{
            $id_training =  TorCDuration::Create([
                'mat'=>'TCD',
                'id_trainer'=>$request->id_trainer,
                'date_start'=> $request->start_training,
                'date_end'=> $request->end_training,
                'type'=>1 ,
                'status'=>1 ,
            ]);
            array_push($schedulearray, array('id'=>$id_training->id,'status'=>1,'isTraining'=>true));
        }
        $length_array=count($schedulearray);
    //---------------------------------------------
        for ($i=0; $i < $length_array; $i++) { 
            //valida si es training o coaching la semana en curso
                if ($schedulearray[$i]['isTraining']==true) {
                    $start_week='';
                    $start_training=Carbon::parse($request->start_training);
                    $day_start=$start_training->dayOfWeek;
                    $day_end=Carbon::parse($request->end_training)->dayOfWeek;
                    $start_week=Carbon::parse($request->start_training)->startOfWeek(Carbon::SUNDAY);
                    $end_week=Carbon::parse($request->start_training)->endOfWeek(Carbon::SATURDAY);
                    $Week=$request->numWeek;
                    $day_start_week=$start_week->dayOfWeek;
                    $day_end_week=$end_week->dayOfWeek;

                    $end_training=Carbon::parse($request->end_training);



                }else{
                    $start_week='';
                    $start_training=Carbon::parse($request->end_training);
                    $start_training=$start_training->addDay();
                    $day_start=$start_training->dayOfWeek;
                    $day_end=Carbon::parse($request->end_coaching)->dayOfWeek;
                    $start_week=Carbon::parse($request->end_training)->startOfWeek(Carbon::SUNDAY);
                    $end_week=Carbon::parse($request->end_training)->endOfWeek(Carbon::SATURDAY);
                    $Week=$request->numWeek_C;
                    $day_start_week=$start_week->dayOfWeek;
                    $day_end_week=$end_week->dayOfWeek;
                    $end_training=Carbon::parse($request->end_coaching);


                }
            //-------------------
                //for que se repite el numero de semanas que dura el entrenamiendo o el coaching
            for ($j=0; $j < $Week; $j++) { 
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
                    'id_torcduration'=> $schedulearray[$i]['id'] ,
                    'id_operator'=>$user->id,
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
                //Valida en que dia comienza y termina su entrenamiento
                if ($day_start > $day_start_week) {
                    $in=$day_start;
                    $fin=$day_end_week;
                }else{
                    $in=$day_start_week;
                    $fin=$day_end_week;

                }

                if ($end_week > $end_training ) {
                    if ($day_end_week > $day_end) {
                        $fin=$day_end;
                    }else{
                        $fin=$day_end_week;
    
                    } 
                }
                //----------------------------
                for ($k=$in; $k <= $fin ; $k++) { 
                    $daysOff=$request->id_dayOff_T;
                    $status_dayoff=1;
                    foreach ($daysOff as $dayOff) {
                        if ($k==$dayOff) {
                            $status_dayoff=2;
                        }
                        
                    }
                    $training_detail =  TrainingDetailModel::Create([
                        'id_schedule'=>$schedule->id,
                        'id_operator'=> $user->id,
                        'id_day'=>$k ,
                        'mat'=>'TSD' ,
                        'time_start'=>$request->start ,
                        'time_end'=>$request->end ,
                        'type_daily'=>$type,
                        'option'=>0 ,
                        'status'=>$status_dayoff ,
                        ]);
                }
                $start_week->addWeek();
                $end_week->addWeek();
                $day_start=0;

                foreach ($daysOff as $dayOff) {
                    $day_offTable =  DayOffModel::Create([
                        'mat'=>'DOF' ,
                        'id_schedule'=>$schedule->id,
                        'id_day'=>$dayOff ,
                            ]);
                }
            }
        }

        

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
