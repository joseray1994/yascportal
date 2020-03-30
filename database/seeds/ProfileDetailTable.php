<?php

use Illuminate\Database\Seeder;

class ProfileDetailTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tu_detail')->truncate();
        
        $tu_prof = [
            ['id_type_user'=> 1,'id_menu'=> 1,'status'=> 1,],
            ['id_type_user'=> 1,'id_menu'=> 2,'status'=> 1,],
            ['id_type_user'=> 1,'id_menu'=> 3,'status'=> 1,],
            ['id_type_user'=> 1,'id_menu'=> 4,'status'=> 1,],
            ['id_type_user'=> 1,'id_menu'=> 5,'status'=> 1,],
            ['id_type_user'=> 1,'id_menu'=> 6,'status'=> 1,],
            ['id_type_user'=> 1,'id_menu'=> 7,'status'=> 1,],
            ['id_type_user'=> 1,'id_menu'=> 8,'status'=> 1,],
            ['id_type_user'=> 1,'id_menu'=> 9,'status'=> 1,],
            ['id_type_user'=> 1,'id_menu'=> 10,'status'=> 1,],
            ['id_type_user'=> 1,'id_menu'=> 11,'status'=> 1,],
            ['id_type_user'=> 1,'id_menu'=> 12,'status'=> 1,],
            ['id_type_user'=> 1,'id_menu'=> 13,'status'=> 1,],
            ['id_type_user'=> 1,'id_menu'=> 14,'status'=> 1,],
            ['id_type_user'=> 1,'id_menu'=> 15,'status'=> 1,],


            ['id_type_user'=> 2,'id_menu'=> 1,'status'=> 1,],
            ['id_type_user'=> 2,'id_menu'=> 2,'status'=> 1,],
            ['id_type_user'=> 2,'id_menu'=> 3,'status'=> 1,],
            ['id_type_user'=> 2,'id_menu'=> 4,'status'=> 1,],
            ['id_type_user'=> 2,'id_menu'=> 5,'status'=> 1,],
            ['id_type_user'=> 2,'id_menu'=> 6,'status'=> 1,],
            ['id_type_user'=> 2,'id_menu'=> 7,'status'=> 1,],
            ['id_type_user'=> 2,'id_menu'=> 8,'status'=> 1,],
            ['id_type_user'=> 2,'id_menu'=> 10,'status'=> 1,],
            ['id_type_user'=> 2,'id_menu'=> 9,'status'=> 1,],
            ['id_type_user'=> 2,'id_menu'=> 11,'status'=> 1,],
            ['id_type_user'=> 2,'id_menu'=> 12,'status'=> 1,],
            ['id_type_user'=> 2,'id_menu'=> 13,'status'=> 1,],
            ['id_type_user'=> 2,'id_menu'=> 14,'status'=> 1,],
            ['id_type_user'=> 2,'id_menu'=> 15,'status'=> 1,],


            ['id_type_user'=> 3,'id_menu'=> 1,'status'=> 1,],
            ['id_type_user'=> 3,'id_menu'=> 2,'status'=> 1,],
            ['id_type_user'=> 3,'id_menu'=> 3,'status'=> 1,],
            ['id_type_user'=> 3,'id_menu'=> 4,'status'=> 1,],
            ['id_type_user'=> 3,'id_menu'=> 5,'status'=> 1,],
            ['id_type_user'=> 3,'id_menu'=> 6,'status'=> 1,],
            ['id_type_user'=> 3,'id_menu'=> 7,'status'=> 1,],
            ['id_type_user'=> 3,'id_menu'=> 8,'status'=> 1,],
            ['id_type_user'=> 3,'id_menu'=> 10,'status'=> 1,],
            ['id_type_user'=> 3,'id_menu'=> 9,'status'=> 1,],
            ['id_type_user'=> 3,'id_menu'=> 11,'status'=> 1,],
            ['id_type_user'=> 3,'id_menu'=> 12,'status'=> 1,],
            ['id_type_user'=> 3,'id_menu'=> 13,'status'=> 1,],
            ['id_type_user'=> 3,'id_menu'=> 14,'status'=> 1,],
            ['id_type_user'=> 3,'id_menu'=> 15,'status'=> 1,],


            ['id_type_user'=> 4,'id_menu'=> 1,'status'=> 1,],
            ['id_type_user'=> 4,'id_menu'=> 2,'status'=> 1,],
            ['id_type_user'=> 4,'id_menu'=> 3,'status'=> 1,],
            ['id_type_user'=> 4,'id_menu'=> 4,'status'=> 1,],
            ['id_type_user'=> 4,'id_menu'=> 5,'status'=> 1,],
            ['id_type_user'=> 4,'id_menu'=> 6,'status'=> 1,],
            ['id_type_user'=> 4,'id_menu'=> 7,'status'=> 1,],
            ['id_type_user'=> 4,'id_menu'=> 8,'status'=> 1,],
            ['id_type_user'=> 4,'id_menu'=> 10,'status'=> 1,],
            ['id_type_user'=> 4,'id_menu'=> 9,'status'=> 1,],
            ['id_type_user'=> 4,'id_menu'=> 11,'status'=> 1,],
            ['id_type_user'=> 4,'id_menu'=> 12,'status'=> 1,],
            ['id_type_user'=> 4,'id_menu'=> 13,'status'=> 1,],
            ['id_type_user'=> 4,'id_menu'=> 14,'status'=> 1,],
            ['id_type_user'=> 4,'id_menu'=> 15,'status'=> 1,],


            ['id_type_user'=> 5,'id_menu'=> 1,'status'=> 1,],
            ['id_type_user'=> 5,'id_menu'=> 2,'status'=> 1,],
            ['id_type_user'=> 5,'id_menu'=> 3,'status'=> 1,],
            ['id_type_user'=> 5,'id_menu'=> 4,'status'=> 1,],
            ['id_type_user'=> 5,'id_menu'=> 5,'status'=> 1,],
            ['id_type_user'=> 5,'id_menu'=> 6,'status'=> 1,],
            ['id_type_user'=> 5,'id_menu'=> 7,'status'=> 1,],
            ['id_type_user'=> 5,'id_menu'=> 8,'status'=> 1,],
            ['id_type_user'=> 5,'id_menu'=> 10,'status'=> 1,],
            ['id_type_user'=> 5,'id_menu'=> 9,'status'=> 1,],
            ['id_type_user'=> 5,'id_menu'=> 11,'status'=> 1,],
            ['id_type_user'=> 5,'id_menu'=> 12,'status'=> 1,],
            ['id_type_user'=> 5,'id_menu'=> 13,'status'=> 1,],
            ['id_type_user'=> 5,'id_menu'=> 14,'status'=> 1,],
            ['id_type_user'=> 5,'id_menu'=> 15,'status'=> 1,],


            ['id_type_user'=> 6,'id_menu'=> 1,'status'=> 1,],
            ['id_type_user'=> 6,'id_menu'=> 2,'status'=> 1,],
            ['id_type_user'=> 6,'id_menu'=> 3,'status'=> 1,],
            ['id_type_user'=> 6,'id_menu'=> 4,'status'=> 1,],
            ['id_type_user'=> 6,'id_menu'=> 5,'status'=> 1,],
            ['id_type_user'=> 6,'id_menu'=> 6,'status'=> 1,],
            ['id_type_user'=> 6,'id_menu'=> 7,'status'=> 1,],
            ['id_type_user'=> 6,'id_menu'=> 8,'status'=> 1,],
            ['id_type_user'=> 6,'id_menu'=> 10,'status'=> 1,],
            ['id_type_user'=> 6,'id_menu'=> 9,'status'=> 1,],
            ['id_type_user'=> 6,'id_menu'=> 11,'status'=> 1,],
            ['id_type_user'=> 6,'id_menu'=> 12,'status'=> 1,],
            ['id_type_user'=> 6,'id_menu'=> 13,'status'=> 1,],
            ['id_type_user'=> 6,'id_menu'=> 14,'status'=> 1,],
            ['id_type_user'=> 6,'id_menu'=> 15,'status'=> 1,],


            ['id_type_user'=> 7,'id_menu'=> 1,'status'=> 1,],
            ['id_type_user'=> 7,'id_menu'=> 2,'status'=> 1,],
            ['id_type_user'=> 7,'id_menu'=> 3,'status'=> 1,],
            ['id_type_user'=> 7,'id_menu'=> 4,'status'=> 1,],
            ['id_type_user'=> 7,'id_menu'=> 5,'status'=> 1,],
            ['id_type_user'=> 7,'id_menu'=> 6,'status'=> 1,],
            ['id_type_user'=> 7,'id_menu'=> 7,'status'=> 1,],
            ['id_type_user'=> 7,'id_menu'=> 8,'status'=> 1,],
            ['id_type_user'=> 7,'id_menu'=> 10,'status'=> 1,],
            ['id_type_user'=> 7,'id_menu'=> 9,'status'=> 1,],
            ['id_type_user'=> 7,'id_menu'=> 11,'status'=> 1,],
            ['id_type_user'=> 7,'id_menu'=> 12,'status'=> 1,],
            ['id_type_user'=> 7,'id_menu'=> 13,'status'=> 1,],
            ['id_type_user'=> 7,'id_menu'=> 14,'status'=> 1,],
            ['id_type_user'=> 7,'id_menu'=> 15,'status'=> 1,],


            ['id_type_user'=> 8,'id_menu'=> 1,'status'=> 1,],
            ['id_type_user'=> 8,'id_menu'=> 2,'status'=> 1,],
            ['id_type_user'=> 8,'id_menu'=> 3,'status'=> 1,],
            ['id_type_user'=> 8,'id_menu'=> 4,'status'=> 1,],
            ['id_type_user'=> 8,'id_menu'=> 5,'status'=> 1,],
            ['id_type_user'=> 8,'id_menu'=> 6,'status'=> 1,],
            ['id_type_user'=> 8,'id_menu'=> 7,'status'=> 1,],
            ['id_type_user'=> 8,'id_menu'=> 8,'status'=> 1,],
            ['id_type_user'=> 8,'id_menu'=> 10,'status'=> 1,],
            ['id_type_user'=> 8,'id_menu'=> 9,'status'=> 1,],
            ['id_type_user'=> 8,'id_menu'=> 11,'status'=> 1,],
            ['id_type_user'=> 8,'id_menu'=> 12,'status'=> 1,],
            ['id_type_user'=> 8,'id_menu'=> 13,'status'=> 1,],
            ['id_type_user'=> 8,'id_menu'=> 14,'status'=> 1,],
            ['id_type_user'=> 8,'id_menu'=> 15,'status'=> 1,],


            ['id_type_user'=> 9,'id_menu'=> 1,'status'=> 1,],
            ['id_type_user'=> 9,'id_menu'=> 2,'status'=> 1,],
            ['id_type_user'=> 9,'id_menu'=> 3,'status'=> 1,],
            ['id_type_user'=> 9,'id_menu'=> 4,'status'=> 1,],
            ['id_type_user'=> 9,'id_menu'=> 5,'status'=> 1,],
            ['id_type_user'=> 9,'id_menu'=> 6,'status'=> 1,],
            ['id_type_user'=> 9,'id_menu'=> 7,'status'=> 1,],
            ['id_type_user'=> 9,'id_menu'=> 8,'status'=> 1,],
            ['id_type_user'=> 9,'id_menu'=> 10,'status'=> 1,],
            ['id_type_user'=> 9,'id_menu'=> 9,'status'=> 1,],
            ['id_type_user'=> 9,'id_menu'=> 11,'status'=> 1,],
            ['id_type_user'=> 9,'id_menu'=> 12,'status'=> 1,],
            ['id_type_user'=> 9,'id_menu'=> 13,'status'=> 1,],
            ['id_type_user'=> 9,'id_menu'=> 14,'status'=> 1,],
            ['id_type_user'=> 9,'id_menu'=> 15,'status'=> 1,],


            ['id_type_user'=> 10,'id_menu'=> 1,'status'=> 1,],
            ['id_type_user'=> 10,'id_menu'=> 2,'status'=> 1,],
            ['id_type_user'=> 10,'id_menu'=> 3,'status'=> 1,],
            ['id_type_user'=> 10,'id_menu'=> 4,'status'=> 1,],
            ['id_type_user'=> 10,'id_menu'=> 5,'status'=> 1,],
            ['id_type_user'=> 10,'id_menu'=> 6,'status'=> 1,],
            ['id_type_user'=> 10,'id_menu'=> 7,'status'=> 1,],
            ['id_type_user'=> 10,'id_menu'=> 8,'status'=> 1,],
            ['id_type_user'=> 10,'id_menu'=> 10,'status'=> 1,],
            ['id_type_user'=> 10,'id_menu'=> 9,'status'=> 1,],
            ['id_type_user'=> 10,'id_menu'=> 11,'status'=> 1,],
            ['id_type_user'=> 10,'id_menu'=> 12,'status'=> 1,],
            ['id_type_user'=> 10,'id_menu'=> 13,'status'=> 1,],
            ['id_type_user'=> 10,'id_menu'=> 14,'status'=> 1,],
            ['id_type_user'=> 10,'id_menu'=> 15,'status'=> 1,],


            ['id_type_user'=> 11,'id_menu'=> 1,'status'=> 1,],
            ['id_type_user'=> 11,'id_menu'=> 2,'status'=> 1,],
            ['id_type_user'=> 11,'id_menu'=> 3,'status'=> 1,],
            ['id_type_user'=> 11,'id_menu'=> 4,'status'=> 1,],
            ['id_type_user'=> 11,'id_menu'=> 5,'status'=> 1,],
            ['id_type_user'=> 11,'id_menu'=> 6,'status'=> 1,],
            ['id_type_user'=> 11,'id_menu'=> 7,'status'=> 1,],
            ['id_type_user'=> 11,'id_menu'=> 8,'status'=> 1,],
            ['id_type_user'=> 11,'id_menu'=> 10,'status'=> 1,],
            ['id_type_user'=> 11,'id_menu'=> 9,'status'=> 1,],
            ['id_type_user'=> 11,'id_menu'=> 11,'status'=> 1,],
            ['id_type_user'=> 11,'id_menu'=> 12,'status'=> 1,],
            ['id_type_user'=> 11,'id_menu'=> 13,'status'=> 1,],
            ['id_type_user'=> 11,'id_menu'=> 14,'status'=> 1,],
            ['id_type_user'=> 11,'id_menu'=> 15,'status'=> 1,],

          ];

      foreach($tu_prof as $tu_prof){
        DB::table('tu_detail')->insert($tu_prof);
                    }
    }
}
