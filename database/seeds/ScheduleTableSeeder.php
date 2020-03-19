<?php

use Illuminate\Database\Seeder;
use App\User;
use App\User_client;
use App\ScheduleModel;
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

        $now1 = Carbon::now();
        $now2 = Carbon::now();
        $now3 = Carbon::now();
        $now4 = Carbon::now();
        $now5 = Carbon::now();

        DB::table('schedule')->truncate();
        DB::table('detail_schedule_user')->truncate();

        $operators = User_client::select('users_client.id', 'users_client.id_client')
            ->join('users', 'users_client.id_user', '=', 'users.id')
            ->where('users.id_type_user', 9)
            ->where('users.id_status', 1)
            ->get();

        foreach ($operators as $operator) { 

            $schedules = [
                [
                    // 'id_trainer' => 1, 
                    'id_operator' => $operator['id'], 
                    'id_client' => $operator['id_client'], 
                    'date_start' => $now1->startOfWeek(Carbon::SUNDAY), 
                    'date_end' => $now2->endOfWeek(Carbon::SATURDAY), 
                    'type_schedule' => '1', 
                    'week' => $now3->weekOfYear, 
                    'month' => $now4->month, 
                    'year' => $now5->year, 
                    'status' => '1'
                ]
            ];
            DB::table('schedule')->insert($schedules);
            
        }

        $schedules = ScheduleModel::select('id', 'id_operator')->where('status', 1)->get();
        $days = DaysModel::select('id')->get();

        foreach ($schedules as $schedule) {

            foreach($days as $day){

                $detail = [
                [
                    "id_schedule"=>$schedule['id'],
                    "id_operator"=>$schedule['id_operator'],
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

        //CLONAR EL SCHEDULE ANTERIOR 
        //OBTENER SCHEDULE ANTERIOR DE USUARIO ACTIVOS
        $schedules = ScheduleModel::where('status', 1)->get();

  
        foreach($schedules as $schedule){
            $nextStartWeek = Carbon::parse($schedule['date_start'])->addWeek();
            $nextEndWeek = Carbon::parse($schedule['date_end'])->addWeek();
            $next2StartWeek = Carbon::parse($schedule['date_start'])->addWeeks(2);
            $next2EndWeek = Carbon::parse($schedule['date_end'])->addWeeks(2);

            $schedules = [
                [
                    // 'id_trainer' => $schedule['id_trainer'], 
                    'id_operator' => $schedule['id_operator'], 
                    'id_client' => $schedule['id_client'], 
                    'date_start' => $nextStartWeek, 
                    'date_end' =>  $nextEndWeek, 
                    'type_schedule' => $schedule['type_schedule'], 
                    'week' => $nextEndWeek->weekOfYear, 
                    'month' => $nextEndWeek->month, 
                    'year' => $nextEndWeek->year, 
                    'status' =>1
                ]
            ];
            DB::table('schedule')->insert($schedules);
            $schedules = [
                [
                    // 'id_trainer' => $schedule['id_trainer'], 
                    'id_operator' => $schedule['id_operator'], 
                    'id_client' => $schedule['id_client'], 
                    'date_start' => $next2StartWeek, 
                    'date_end' =>  $next2EndWeek, 
                    'type_schedule' => $schedule['type_schedule'], 
                    'week' => $next2EndWeek->weekOfYear, 
                    'month' => $next2EndWeek->month, 
                    'year' => $next2EndWeek->year, 
                    'status' =>1
                ]
            ];
            DB::table('schedule')->insert($schedules);
        }


    }
}
