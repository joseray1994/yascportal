<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignamentTypeModel extends Model
{
    protected $table = 'tu_detail';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_type_user','id_menu ','basic_actions',
    ];
}
