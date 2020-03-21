<?php

use Illuminate\Database\Seeder;
use App\User;
use App\User_client;
use App\ScheduleModel;
use App\ScheduleDetailModel;
use App\DaysModel;
use Carbon\Carbon; 


class ScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // OBTENER TODOS LOS OPERADORES ACTIVOS
        $operators = User_client::select('users_client.id_user as id_user', 'users_client.id_client as id_client')
            ->join('users', 'users_client.id_user', '=', 'users.id')
            ->where('users.id_type_user', 9)
            ->where('users.id_status', 1)
            ->get();

        // CICLO PARA CREAR SCHEDULE
        foreach ($operators as $operator) { 

            //VALIDAR SI TIENE SCHEDULE, SI TIENE, PARTIR DE ESE, SINO INICIAR EN 0
            $validaSchedule = ScheduleModel::where('id_operator', $operator['id_user'])->where('type_schedule', 1)->where('status', 1)->exists();
            
            if($validaSchedule){

                $now = Carbon::now();

                $validaScheduleThisWeek = ScheduleModel::where('id_operator', $operator['id_user'])->where('type_schedule', 1)->where('status', 1)->whereDate('date_start', Carbon::parse($now)->startOfWeek(Carbon::SUNDAY))->exists();

                //VALIDAR QUE NO EXISTA SCHEDULE ESTA SEMANA
                if(!$validaScheduleThisWeek){
                    // OBTENER ULTIMA SEMANA PARA PARTIR DE ESOS DATOS
                    $startLastWeek = Carbon::parse($now)->subWeek()->startOfWeek(Carbon::SUNDAY);
                    $endLastWeek = Carbon::parse($now)->subWeek()->endOfWeek(Carbon::SATURDAY);
                    
                    $getIdSchedules = ScheduleModel::where('id_operator', $operator['id_user'])->where('type_schedule', 1)->where('status', 1)->whereDate('date_start', $startLastWeek)->first();
    
                    $getScheduleDetail = ScheduleDetailModel::where('id_schedule', $getIdSchedules['id'])->get();
    
                    // CREAR SCHEDULE DE SEMANA UNO
                    $schedulesSemanaUno = ScheduleModel::Create([
                        'id_operator' => $operator['id_user'], 
                        'id_client' => $operator['id_client'],
                        'date_start' => Carbon::parse($now)->startOfWeek(Carbon::SUNDAY),
                        'date_end' => Carbon::parse($now)->endOfWeek(Carbon::SATURDAY),
                        'type_schedule' => '1',
                        'week' =>Carbon::parse($now)->weekOfYear,
                        'month' => Carbon::parse($now)->month,
                        'year' => Carbon::parse($now)->year,
                        'status' => '1'
                    ]) ;
    
                    // CREAR DETALLES DE LA SEMANA UNO
                    foreach ($getScheduleDetail as $detailSchedule) {
    
                        $detail = ScheduleDetailModel::Create([
                            "id_schedule"=>$schedulesSemanaUno->id,
                            "id_operator"=>$detailSchedule['id_operator'],
                            "id_day"=>$detailSchedule['id_day'],
                            "time_start"=>$detailSchedule['time_start'],
                            "time_end"=>$detailSchedule['time_end'],
                            "hours"=>$detailSchedule['hours'],
                            "minutes"=>$detailSchedule['minutes'],
                            "type_daily"=>$detailSchedule['type_daily'],
                            "option"=>$detailSchedule['option'],
                            "status"=>1,
                        ]);
                    }

                    // CREAR SEMANA DOS
                    $schedulesSemanaDos = ScheduleModel::Create([
                        'id_operator' => $operator['id_user'], 
                        'id_client' => $operator['id_client'],
                        'date_start' => Carbon::parse($now)->addWeek()->startOfWeek(Carbon::SUNDAY),
                        'date_end' => Carbon::parse($now)->addWeek()->endOfWeek(Carbon::SATURDAY),
                        'type_schedule' => '1',
                        'week' =>Carbon::parse($now)->addWeek()->weekOfYear,
                        'month' => Carbon::parse($now)->addWeek()->month,
                        'year' => Carbon::parse($now)->addWeek()->year,
                        'status' => '1'
                    ]) ;

    
                    // CREAR DETALLES DE LA SEMANA DOS
                    foreach ($getScheduleDetail as $detailSchedule) {
    
                        $detail = ScheduleDetailModel::Create([
                            "id_schedule"=>$schedulesSemanaDos->id,
                            "id_operator"=>$detailSchedule['id_operator'],
                            "id_day"=>$detailSchedule['id_day'],
                            "time_start"=>$detailSchedule['time_start'],
                            "time_end"=>$detailSchedule['time_end'],
                            "hours"=>$detailSchedule['hours'],
                            "minutes"=>$detailSchedule['minutes'],
                            "type_daily"=>$detailSchedule['type_daily'],
                            "option"=>$detailSchedule['option'],
                            "status"=>1,
                        ]);
                    }
                }
                
            }
            else{
                //CREAR EL SCHEDULE DESDE 0

                $now = Carbon::now();
    
                // CREAR SCHEDULE DE SEMANA UNO
                $schedulesSemanaUno = ScheduleModel::Create([
                    'id_operator' => $operator['id_user'], 
                    'id_client' => $operator['id_client'],
                    'date_start' => Carbon::parse($now)->startOfWeek(Carbon::SUNDAY),
                    'date_end' => Carbon::parse($now)->endOfWeek(Carbon::SATURDAY),
                    'type_schedule' => '1',
                    'week' =>Carbon::parse($now)->weekOfYear,
                    'month' => Carbon::parse($now)->month,
                    'year' => Carbon::parse($now)->year,
                    'status' => '1'
                ]);
    
                // OBTENER LOS DIAS DE LA SEMANA
                $days = DaysModel::select('id')->get();
                
                // CREAR DETALLES DE LA SEMANA UNO
                foreach($days as $day){
    
                    $detail = [
                    [
                        "id_schedule"=>$schedulesSemanaUno->id,
                        "id_operator"=>$operator['id_user'], 
                        "id_day"=>$day['id'],
                        "time_start"=>'08:00:00',
                        "time_end"=>'16:30:00',
                        "type_daily"=>1,
                        "option"=>1,
                        "status"=>1,
                        ]
                    ];
                    DB::table('detail_schedule_user')->insert($detail);
                }   

                 // CREAR SCHEDULE DE SEMANA DOS
                 $schedulesSemanaDos = ScheduleModel::Create([
                    'id_operator' => $operator['id_user'], 
                    'id_client' => $operator['id_client'],
                    'date_start' => Carbon::parse($now)->addWeek()->startOfWeek(Carbon::SUNDAY),
                    'date_end' => Carbon::parse($now)->addWeek()->endOfWeek(Carbon::SATURDAY),
                    'type_schedule' => '1',
                    'week' =>Carbon::parse($now)->addWeek()->weekOfYear,
                    'month' => Carbon::parse($now)->addWeek()->month,
                    'year' => Carbon::parse($now)->addWeek()->year,
                    'status' => '1'
                ]);
    
                // OBTENER LOS DIAS DE LA SEMANA
                $days = DaysModel::select('id')->get();
                
                // CREAR DETALLES DE LA SEMANA DOS
                foreach($days as $day){
    
                    $detail = [
                    [
                        "id_schedule"=>$schedulesSemanaDos->id,
                        "id_operator"=>$operator['id_user'], 
                        "id_day"=>$day['id'],
                        "time_start"=>'08:00:00',
                        "time_end"=>'16:30:00',
                        "type_daily"=>1,
                        "option"=>1,
                        "status"=>1,
                        ]
                    ];
                    DB::table('detail_schedule_user')->insert($detail);
                }   
            }            
        }
    }
}
