<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidentReportModel extends Model
{
    protected $table = 'incident_reports';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_setting','id_user', 'id_supervisor', 'start', 'end', 'duration', 'note', 'status', 'created_at', 'updated_at'
    ];
}
