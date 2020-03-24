<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuspendedModel extends Model
{
    protected $table = 'schedule_suspended';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_operator','date_start','date_end','status','creatde_at',
    ];
}
