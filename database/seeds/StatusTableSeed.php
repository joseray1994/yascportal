<?php

use Illuminate\Database\Seeder;

class StatusTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->truncate();
        $status = [
            ['status'=> 0,'description'=>'Hide'],
            ['status'=> 1,'description'=>'Activo'],
            ['status'=> 2,'description'=>'Inactivo'],
            ['status'=> 3,'description'=>'En Espera'],
            ['status'=> 4,'description'=>'Cancelado'],
            ['status'=> 5,'description'=>'Rechazado'],
            ['status'=> 6,'description'=>'Suspendido'],
        ];
      
      foreach($status as $status){
            DB::table('status')->insert($status);
                        }
    }
}
