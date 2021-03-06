<?php

use Illuminate\Database\Seeder;

class ActionsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('basic_actions')->truncate();

        $menus = [
                    ['id_menu'=> 1,'name'=> 'Create'],
                    ['id_menu'=> 1, 'name'=> 'Edit'],
                    ['id_menu'=> 1, 'name'=> 'Update Status'],
                    ['id_menu'=> 1, 'name'=> 'Delete'],
                    ['id_menu'=> 1, 'name'=> 'Activated'],
                    ['id_menu'=> 1, 'name'=> 'Deactivate'],
                    ['id_menu'=> 2,'name'=> 'Create'],
                    ['id_menu'=> 2, 'name'=> 'Edit'],
                    ['id_menu'=> 2, 'name'=> 'Update Status'],
                    ['id_menu'=> 2, 'name'=> 'Delete'],
                    ['id_menu'=> 2, 'name'=> 'Activated'],
                    ['id_menu'=> 2, 'name'=> 'Deactivate'],
                    ['id_menu'=> 3,'name'=> 'Create'],
                    ['id_menu'=> 3, 'name'=> 'Edit'],
                    ['id_menu'=> 3, 'name'=> 'Update Status'],
                    ['id_menu'=> 3, 'name'=> 'Delete'],
                    ['id_menu'=> 3, 'name'=> 'Activated'],
                    ['id_menu'=> 3, 'name'=> 'Deactivate'],
                    ['id_menu'=> 4,'name'=> 'Create'],
                    ['id_menu'=> 4, 'name'=> 'Edit'],
                    ['id_menu'=> 4, 'name'=> 'Update Status'],
                    ['id_menu'=> 4, 'name'=> 'Delete'],
                    ['id_menu'=> 4, 'name'=> 'Activated'],
                    ['id_menu'=> 4, 'name'=> 'Deactivate'],
                    ['id_menu'=> 5,'name'=> 'Create'],
                    ['id_menu'=> 5, 'name'=> 'Edit'],
                    ['id_menu'=> 5, 'name'=> 'Update Status'],
                    ['id_menu'=> 5, 'name'=> 'Delete'],
                    ['id_menu'=> 5, 'name'=> 'Activated'],
                    ['id_menu'=> 5, 'name'=> 'Deactivate'],
                    ['id_menu'=> 6,'name'=> 'Create'],
                    ['id_menu'=> 6, 'name'=> 'Edit'],
                    ['id_menu'=> 6, 'name'=> 'Update Status'],
                    ['id_menu'=> 6, 'name'=> 'Delete'],
                    ['id_menu'=> 6, 'name'=> 'Activated'],
                    ['id_menu'=> 6, 'name'=> 'Deactivate'],
                    ['id_menu'=> 7,'name'=> 'Create'],
                    ['id_menu'=> 7, 'name'=> 'Edit'],
                    ['id_menu'=> 7, 'name'=> 'Update Status'],
                    ['id_menu'=> 7, 'name'=> 'Delete'],
                    ['id_menu'=> 7, 'name'=> 'Activated'],
                    ['id_menu'=> 7, 'name'=> 'Deactivate'],
                    ['id_menu'=> 8,'name'=> 'Create'],
                    ['id_menu'=> 8, 'name'=> 'Edit'],
                    ['id_menu'=> 8, 'name'=> 'Update Status'],
                    ['id_menu'=> 8, 'name'=> 'Delete'],
                    ['id_menu'=> 8, 'name'=> 'Activated'],
                    ['id_menu'=> 8, 'name'=> 'Deactivate'],
                    ['id_menu'=> 9,'name'=> 'Create'],
                    ['id_menu'=> 9, 'name'=> 'Edit'],
                    ['id_menu'=> 9, 'name'=> 'Update Status'],
                    ['id_menu'=> 9, 'name'=> 'Delete'],
                    ['id_menu'=> 9, 'name'=> 'Activated'],
                    ['id_menu'=> 9, 'name'=> 'Deactivate'],
                    ['id_menu'=> 10,'name'=> 'Create'],
                    ['id_menu'=> 10, 'name'=> 'Edit'],
                    ['id_menu'=> 10, 'name'=> 'Update Status'],
                    ['id_menu'=> 10, 'name'=> 'Delete'],
                    ['id_menu'=> 10, 'name'=> 'Activated'],
                    ['id_menu'=> 10, 'name'=> 'Deactivate'],
                    ['id_menu'=> 11,'name'=> 'Create'],
                    ['id_menu'=> 11, 'name'=> 'Edit'],
                    ['id_menu'=> 11, 'name'=> 'Update Status'],
                    ['id_menu'=> 11, 'name'=> 'Delete'],
                    ['id_menu'=> 11, 'name'=> 'Activated'],
                    ['id_menu'=> 11, 'name'=> 'Deactivate'],
                    ['id_menu'=> 12,'name'=> 'Create'],
                    ['id_menu'=> 12, 'name'=> 'Edit'],
                    ['id_menu'=> 12, 'name'=> 'Update Status'],
                    ['id_menu'=> 12, 'name'=> 'Delete'],
                    ['id_menu'=> 12, 'name'=> 'Activated'],
                    ['id_menu'=> 12, 'name'=> 'Deactivate'],
                    
            ];
      
      foreach($menus as $menu){
            DB::table('basic_actions')->insert($menu);
                        }
    }
}
