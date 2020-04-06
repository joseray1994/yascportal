<?php

use Illuminate\Database\Seeder;

class MenuTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('basic_menu')->truncate();

        $menus = [
            ['name'=> 'Types User','icon'=> 'fa fa-address-card','link'=>'/types','prioridad'=> '2','status'=> 1,],
            ['name'=> 'Users','icon'=> 'fa fa-user','link'=>'/users','prioridad'=> '3','status'=> 1,],
            ['name'=> 'Operators','icon'=> 'fa fa-users','link'=>'/operators','prioridad'=> '4','status'=> 1,],
            ['name'=> 'Clients','icon'=> 'fa fa-suitcase','link'=>'/clients','prioridad'=> '4','status'=> 1,],
            ['name'=> 'Schedule Weekly','icon'=> 'fa fa-calendar','link'=>'/weekly','prioridad'=> '5','status'=> 1,],
            ['name'=> 'Settings','icon'=> 'fa fa-wrench','link'=>'/settings','prioridad'=> '7','status'=> 1,],
            ['name'=> 'Schedule Daily','icon'=> 'fa fa-calendar-o','link'=>'/daily','prioridad'=> '5','status'=> 1,],
            ['name'=> 'Reports','icon'=> 'fa fa-file-excel-o','link'=>'/reports','prioridad'=> '7','status'=> 1,],
            ['name'=> 'Vacancies','icon'=> 'fa fa-id-badge','link'=>'/vacancies','prioridad'=> '7','status'=> 1,],
            ['name'=> 'Profile','icon'=> 'fa icon-user','link'=>'/profile','prioridad'=> '8','status'=> 1,],
            ['name'=> 'Training','icon'=> 'fa  fa-book','link'=>'/training','prioridad'=> '6','status'=> 1,],
            ['name'=> 'Zoom','icon'=> 'fa  fa-video-camera','link'=>'/zoom','prioridad'=> '7','status'=> 1,],
            ['name'=> 'News','icon'=> 'fa icon-paper-clip','link'=>'/news','prioridad'=> '7','status'=> 1,],
            ['name'=> 'Dashboard','icon'=> 'fa icon-home','link'=>'/home','prioridad'=> '1','status'=> 1,],
            ['name'=> 'Providers','icon'=> 'fa fa-users','link'=>'/providers','prioridad'=> '7','status'=> 1,],
            ['name'=> 'Inventory','icon'=> 'fa fa-tasks','link'=>'/inventory','prioridad'=> '7','status'=> 1,],
            ['name'=> 'Reminder','icon'=> 'fa fa-file-text-o','link'=>'/reminder','prioridad'=> '7','status'=> 1,],

        ];
      
      foreach($menus as $menu){
            DB::table('basic_menu')->insert($menu);
                        }
 }
    
}
