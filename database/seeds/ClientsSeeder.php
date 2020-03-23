<?php

use Illuminate\Database\Seeder;
use App\ClientModel;
use App\BreakRules;
class ClientsSeeder extends Seeder
{
    
    public function run()
    {
      DB::table('clients')->truncate();
    	$clients = [
            ['name'=> 'Telerep','status'=> 1, 'color' => '1', 'id_time_zone' => 62],
            ['name'=> 'Call Experts','status'=> 1, 'color' => '2', 'id_time_zone' => 62],
            ['name'=> 'Voicelink of houston','status'=> 1, 'color' => '3', 'id_time_zone' => 62],
            ['name'=> 'Southern Voices','status'=> 1, 'color' => '4', 'id_time_zone' => 62],     
            ['name'=> 'Alphapage','status'=> 1, 'color' => '5', 'id_time_zone' => 62],
            ['name'=> 'Answer United','status'=> 1, 'color' => '6', 'id_time_zone' => 62],
            ['name'=> 'Answer Pro','status'=> 1, 'color' => '7', 'id_time_zone' => 62],
            ['name'=> 'Mainline','status'=> 1, 'color' => '8', 'id_time_zone' => 62],
            ['name'=> 'Voicelink of Columbus','status'=> 1, 'color' => '9', 'id_time_zone' => 62],   
            ['name'=> 'Speedez','status'=> 1, 'color' => '10', 'id_time_zone' => 62],
            ['name'=> 'Focus','status'=> 1, 'color' => '11', 'id_time_zone' => 62],
            ['name'=> 'Medical Bureau','status'=> 1, 'color' => '12', 'id_time_zone' => 62],
            ['name'=> 'Etzel','status'=> 1, 'color' => '13', 'id_time_zone' => 62],
            ['name'=> 'CCI','status'=> 1, 'color' => '14', 'id_time_zone' => 62],
            ['name'=> 'Global Messaging','status'=> 1, 'color' => '15', 'id_time_zone' => 62],
            ['name'=> 'Tel-us','status'=> 1, 'color' => '16', 'id_time_zone' => 62],
            ['name'=> 'Nationwide','status'=> 1, 'color' => '17', 'id_time_zone' => 62],
            ['name'=> 'Always Connected','status'=> 1, 'color' => '18', 'id_time_zone' => 62],
            ['name'=> 'Answering Advantage','status'=> 1, 'color' => '19', 'id_time_zone' => 62],
            ['name'=> 'Combined Communications','status'=> 1, 'color' => '20', 'id_time_zone' => 62],
            ['name'=> 'Edwards Ans Svc','status'=> 1, 'color' => '21', 'id_time_zone' => 62],
            ['name'=> 'CCEmerald CoastI','status'=> 1, 'color' => '22', 'id_time_zone' => 62],
            ['name'=> 'Abbott','status'=> 1, 'color' => '23', 'id_time_zone' => 62],
            ['name'=> 'Metro ICG','status'=> 1, 'color' => '24', 'id_time_zone' => 62],
            ['name'=> 'Bay Area Medical','status'=> 1, 'color' => '25', 'id_time_zone' => 62],
           
          ];

      foreach($clients as $client)
      {
        DB::table('clients')->insert($client);
        
      }

       $cbkr = ClientModel::all();
       DB::table('break_rules')->truncate();
       foreach($cbkr as $bk){
         DB::table('break_rules')->insert([
           "interval" => '0',
           "duration" => '0',
           "id_client" => $bk->id
         ]);
       }
    }
}
