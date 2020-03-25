<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users_info')->truncate();
        $adminUser = [
            ['nickname'=> 'admin',
            'id_type_user'=>1,
            'email'=>'admin@yasc.com',
            'password'=> bcrypt('admin'),
            'id_status'=>1]
        ];


        $adminInformation = [
            [
            'id_user' => 1,
            'name'=> 'admin',
            'last_name'=>'admin',
            'address'=>'admin',
            'phone'=> 'admin',
            'emergency_contact_name'=>'admin emegency contact name',
            'emergency_contact_phone'=>'00000000',
            'description'=>'admin desc',
            'gender'=>'X',
            'birthdate'=> Carbon::now(),
            'profile_picture'=>'admin',
            'entrance_date'=> Carbon::now(),
            'biotime_status'=> '1',
            'access_code'=>12322332]
        ];
      
      foreach($adminUser as $admin)
      {
            $user = DB::table('users')->insert($admin);
            $user = DB::table('users_info')->insert($adminInformation);
        }
    

    for ($i = 2; $i <= 101; $i++) {

            $operator2 = [
                ['nickname'=> 'operator'.$i,
                'id_type_user'=>9,
                'email'=>'operator'.$i.'@yasc.com',
                'password'=> bcrypt('operator'),
                'id_status'=>1]
            ];


            $operatorInformation2 = [
                [
                'id_user' => $i,
                'name'=> 'operator'.$i.'',
                'last_name'=>'operator'.$i.'',
                'address'=>'operator',
                'phone'=> 'operator',
                'emergency_contact_name'=>'operator'.$i.' emegency contact name',
                'emergency_contact_phone'=>'0000'.$i.'0000',
                'description'=>'operator'.$i.' desc',
                'gender'=>'X',
                'birthdate'=> Carbon::now(),
                'profile_picture'=>'operator',
                'entrance_date'=> Carbon::now(),
                'biotime_status'=> '1',
                'access_code'=>12322332]
            ];

            $user2 = DB::table('users')->insert($operator2);
            $user2 = DB::table('users_info')->insert($operatorInformation2);
    }

}
           
}
