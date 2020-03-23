<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeZoneModel extends Model
{
    protected $table = 'time_zone';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mat', 'name', 'offset', 'status'
    ];
}
