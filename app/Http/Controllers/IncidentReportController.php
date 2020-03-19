<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\IncidentReportModel;
use Carbon\Carbon; 

class IncidentReportController extends Controller
{
    public function store(Request $request){
        $user = Auth::user();
        $now = Carbon::now();

        $validaIncident = IncidentReportController::validaIncident($user->id);
        if($validaIncident){
            $incident = IncidentReportModel::where('id_user', $user->id)->first();
            $data = ["flag"=>1, "msg"=>"This user already has an issue", "incident"=>$incident];
            return $data;
        }

        $incident = IncidentReportModel::Create([
            'id_setting'=>"0",
            'id_user'=>$user->id,
            'id_supervisor'=>"0",
            'start'=>$now,
            'end'=>"",
            'duration'=>"0",
            'note'=>""
        ]);
        return response()->json($incident);
    }

    public function validaIncident($id){
        $incident = IncidentReportModel::where('id_user', $id)->where('status', 1)->exists();
        return $incident;
    }

    public function update(Request $request){

        $user = Auth::user();
        $now = Carbon::now();

        $incident = IncidentReportModel::where('id_user', $user->id)->first();
        $dateStart = Carbon::parse($incident->start);
        $dateEnd = Carbon::parse($now);

        $diff = $dateStart->diff($dateEnd);
        $hour = $diff->h;
        $minutes = $diff->i;
        $seconds = $diff->s;
        if($hour < 10){
            $hour = '0'.$hour;
        }
        if($minutes < 10){
            $minutes = '0'.$minutes;
        }
        if($seconds < 10){
            $seconds = '0'.$seconds;
        }
        $duration = $hour . ':'.$minutes . ':'.$seconds;

        $incident->id_setting = $request->reason;
        $incident->id_supervisor = $request->supervisor;
        $incident->end = $now;
        $incident->duration = $duration;
        $incident->note = $request->note;
        $incident->status = 2;
        $incident->update();
        return response()->json($incident);
    }

    public function getIncidents($id){
        
    }
}