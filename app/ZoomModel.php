<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoomModel extends Model
{
    protected $table = 'zoom';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name','email', 'password', 'status', 'in_use_by',
    ];
}
