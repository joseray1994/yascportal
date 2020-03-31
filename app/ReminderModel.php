<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReminderModel extends Model
{
    protected $table = 'reminder';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_user', 'title', 'reminder', 'start_date','end_date','status',
    ];
}
