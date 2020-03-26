<?php

use Illuminate\Database\Seeder;
use App\ZoomModel;
class ZoomSeeder extends Seeder
{
    
    public function run()
    {
      DB::table('zoom')->truncate();
    	$zoom = [
            ['name'=> 'IT Department', 'email' => 'itdept@yasc.us', 'status'=> 1, 'password' => '20.Yasc.20'],
            ['name'=> 'Account Manager', 'email' => 'accountmanager@yascemail.com', 'status'=> 1, 'password' => '20.Yasc.20'],
            ['name'=> 'Training 1', 'email' => 'training1@youranswersolutionscenter.com', 'status'=> 1, 'password' => 'Y@sc2018'],
            ['name'=> 'Training 2', 'email' => 'training2@youranswersolutionscenter.com','status'=> 1, 'password' => 'Y@sc2018'],     
            ['name'=> 'Training 3', 'email' => 'training3@youranswersolutionscenter.com', 'status'=> 1, 'password' => 'Y@sc2018'],
            ['name'=> 'Training 4', 'email' => 'training4@youranswersolutionscenter.com', 'status'=> 1, 'password' => 'Y@sc2018'],
            ['name'=> 'Training 5', 'email' => 'training5@youranswersolutionscenter.com', 'status'=> 1, 'password' => 'Y@sc2018'],
            ['name'=> 'Training 6', 'email' => 'training6@youranswersolutionscenter.com', 'status'=> 1, 'password' => 'Y@sc2018'],
            ['name'=> 'Training 7', 'email' => 'training7@youranswersolutionscenter.com', 'status'=> 1, 'password' => 'Y@sc2018'],   
            ['name'=> 'Training 8', 'email' => 'training8@youranswersolutionscenter.com', 'status'=> 1, 'password' => 'Y@sc2018'],
            ['name'=> 'Training 9', 'email' => 'training9@youranswersolutionscenter.com', 'status'=> 1, 'password' => 'Y@sc2018'],
            ['name'=> 'Training 10', 'email' => 'training10@youranswersolutionscenter.com', 'status'=> 1, 'password' => 'Y@sc2018'],
            ['name'=> 'Training 11', 'email' => 'training11@youranswersolutionscenter.com', 'status'=> 1, 'password' => 'Y@sc2018'],
            ['name'=> 'Training 12', 'email' => 'training12@youranswersolutionscenter.com', 'status'=> 1, 'password' => 'Y@sc2018'],
            ['name'=> 'Training 13', 'email' => 'training13@youranswersolutionscenter.com', 'status'=> 1, 'password' => 'Y@sc2018'],
            ['name'=> 'Training 14', 'email' => 'training14@youranswersolutionscenter.com', 'status'=> 1, 'password' => 'Y@sc2018'],
            ['name'=> 'Training 15', 'email' => 'training15@youranswersolutionscenter.com', 'status'=> 1, 'password' => 'Y@sc2018'],
            ['name'=> 'Training 16', 'email' => 'training16@youranswersolutionscenter.com', 'status'=> 1, 'password' => 'Y@sc2018'],
           
          ];

      foreach($zoom as $zm)
      {
        DB::table('zoom')->insert($zm);
        
      }

      
    }
}
