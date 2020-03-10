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

        $now = Carbon::now();
        $now2 = Carbon::now();
        $now3 = Carbon::now();

        DB::table('schedule')->truncate();
        DB::table('detail_schedule_user')->truncate();

        $operators = User_client::select('users_client.id', 'users_client.id_client')
            ->join('users', 'users_client.id_user', '=', 'users.id')
            ->where('users.id_type_user', 9)
            ->get();

        foreach ($operators as $operator) { 

            $schedules = [
                [
                    'id_trainer' => 1, 
                    'id_operator' => $operator['id'], 
                    'id_client' => $operator['id_client'], 
                    'date_start' => $now->startOfWeek(Carbon::SUNDAY), 
                    'date_end' => $now2->endOfWeek(Carbon::SATURDAY), 
                    'type_schedule' => '1', 
                    'week' => $now3->weekOfYear, 
                    'month' => $now->month, 
                    'year' => $now->year, 
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
                    "type_daily"=>2,
                    "option"=>1,
                    "status"=>1,
                    ]
                ];
                DB::table('detail_schedule_user')->insert($detail);
            }
        }
    }
}
