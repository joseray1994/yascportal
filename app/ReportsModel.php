<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportsModel extends Model
{
    protected $table = 'incident_reports';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_setting','id_user', 'duration', 'note', 'status', 'created_at', 'updated_at'
    ];
}
