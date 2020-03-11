<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleTrainingModel extends Model
{
    protected $table = 'schedule';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_torcduration','id_operator','id_client','mat','date_start','date_end','type_schedule','week','month','year','status','created_at','updated_at'
    ];
}
