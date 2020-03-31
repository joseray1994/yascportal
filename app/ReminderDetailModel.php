<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReminderDetailModel extends Model
{
    protected $table = 'user_view_reminders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_reminder', 'id_user',
    ];
}
