<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingDetailModel extends Model
{
    protected $table = 'detail_schedule_user';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_schedule','id_operator','id_day','date','mat','time_start','time_end','type_daily', 'option','status'
    ];
}
