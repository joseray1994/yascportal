<?php

use Illuminate\Database\Seeder;
use App\ClientColorModel;
class ClientColorSeeder extends Seeder
{
    
    public function run()
    {
    	$colors = [
            ['hex'=> "#ccfff2",],
            ['hex'=> "#c6d9eb"],
            ['hex'=> "#ffb399"],
            ['hex'=> "#ffdd99"],
            ['hex'=> "#f0b3ff"],
            ['hex'=> "#cc99ff"],
            ['hex'=> "#9999ff"],
            ['hex'=> "#b3ffec"],
            ['hex'=> "#df9fdf"],
            ['hex'=> "#b3ffff"],
            ['hex'=> "#ffffcc"],
            ['hex'=> "#ffa366"],
            ['hex'=> "#ff80bf"],
            ['hex'=> "#a3a3c2"],
            ['hex'=> "#d9b38c"],
            ['hex'=> "#f2ffcc"],
            ['hex'=> "#e6ffff"],
            ['hex'=> "#ccccff"],
            ['hex'=> "#ff66a3"],
            ['hex'=> "#ff80b3"],
            ['hex'=> "#ffeecc"],
            ['hex'=> "#c2d6d6"],
            ['hex'=> "#ff8566"],
            ['hex'=> "#ffcc80"],
            ['hex'=> "#ffb3d9"],
            ['hex'=> "#cccc99"],
            ['hex'=> "#bfbfbf"],
            ['hex'=> "#6699ff"],
            ['hex'=> "#b3b3b3"],
            ['hex'=> "#ffb366"],
           
          ];

      foreach($colors as $color)
      {
        DB::table('client_color')->insert($color);
      }
    }
}
