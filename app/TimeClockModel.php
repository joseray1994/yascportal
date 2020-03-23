<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeClockModel extends Model
{
    protected $table = 'schedule_time_clock';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_schedule','id_schedule_detail','id_operator','id_client','date_start','date_end','duration','type','status','creatde_at','updated_at'
    ];
    
}
