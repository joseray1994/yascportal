<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TorCDuration extends Model
{
    protected $table = 't_or_c_duration';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mat','id_trainer','id_operator','date_start','date_end','type','status'
    ];
}
