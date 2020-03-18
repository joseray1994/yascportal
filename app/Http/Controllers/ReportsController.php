<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\DaysModel;
use App\ReportsModel;
use App\ClientModel;
use App\User_info;
use App\ScheduleModel;
use App\TimeClockModel;
use Carbon\Carbon; 
class ReportsController extends Controller
{
   //
    public function incident_report(Request $request)
    {
    //    dd($request);
        $user = Auth::user();
        $id_menu=8;
        $menu = menu($user,$id_menu);
        if($menu['validate']){          
        
          $days = DaysModel::all();
          $clients = ClientModel::all();
          $operators = User_info::select('users_info.id_user as id_user',
                                         'users_info.name as name', 
                                         'users_info.last_name as last_name',
                                         )
                                  ->join('users as user', 'user.id', '=', 'users_info.id_user')   
                                  ->where('user.id_type_user', 9)
                                  ->get();    

          
          if($request->date_start && $request->date_end){
            $date_start =Carbon::parse($request->date_start);
            $date_start = $date_start->format('Y-m-d');

            $date_end =Carbon::parse($request->date_end);
            $date_end = $date_end->format('Y-m-d');
            // dd($date_end);
            $reports = ReportsModel::select('incident_reports.id as id',
                                              'incident_reports.id_user as id_user',
                                              'user.name as name',
                                              'user.last_name as last_name',
                                              'clt.id as id_client',
                                              'clt.name as client_name',
                                              'incident_reports.start as start',
                                              'incident_reports.end as end',
                                              'incident_reports.duration as duration',
                                              'incident_reports.note as note',
                                              'incident_reports.status as status',
                                              'set.name as setting_name',
                                              'userS.name as supervisor_name',
                                              'userS.last_name as supervisor_last_name'
                                              )
                                      ->join('users_info as user', 'user.id_user', '=', 'incident_reports.id_user')
                                      ->join('users_info as userS', 'userS.id_user', '=', 'incident_reports.id_supervisor')
                                      ->join('users_client as uclt', 'uclt.id_user', '=', 'incident_reports.id_user')
                                      ->join('clients as clt', 'clt.id', '=', 'uclt.id_client')
                                      ->join('settings as set', 'set.id', '=', 'id_setting')
                                      ->whereBetween('incident_reports.start', [$date_start, $date_end]);

                                      if($request->operator != "AllOperators"){
                                        $reports->where('user.id_user',"=", $request->operator);
                                    }

                                    if($request->operator != "AllClients"){
                                        $reports->where('uclt.id_client',"=", $request->client);
                                    }

                                    
                                   
          }
          else
          {
            $now = Carbon::now();
            $today = $now->format('Y-m-d');
            $reports = ReportsModel::select('incident_reports.id as id',
                                              'incident_reports.id_user as id_user',
                                              'user.name as name',
                                              'user.last_name as last_name',
                                              'clt.id as id_client',
                                              'clt.name as client_name',
                                              'incident_reports.start as start',
                                              'incident_reports.end as end',
                                              'incident_reports.duration as duration',
                                              'incident_reports.note as note',
                                              'incident_reports.status as status',
                                              'set.name as setting_name',
                                              'userS.name as supervisor_name',
                                              'userS.last_name as supervisor_last_name'
                                              )
                                      ->join('users_info as user', 'user.id_user', '=', 'incident_reports.id_user')
                                      ->join('users_info as userS', 'userS.id_user', '=', 'incident_reports.id_supervisor')
                                      ->join('users_client as uclt', 'uclt.id_user', '=', 'incident_reports.id_user')
                                      ->join('clients as clt', 'clt.id', '=', 'uclt.id_client')
                                      ->join('settings as set', 'set.id', '=', 'id_setting')
                                      ->where('incident_reports.start', 'LIKE', '%'.$today.'%');

          }                        
         

       
        $data=$reports->paginate(5);
        // dd($data);
        if ($request->ajax()) {
            return view('reports.incidents', ["reports"=>$data]);
        }

        return view('reports.index', ["menu"=>$menu, "days"=>$days, "reports" => $data, "clients" => $clients, "operators" => $operators]);
        }
        else
        {
            return redirect('/');
        }
    }

    public function attendance_report(Request $request){
        $attendance = ScheduleModel::all();
    }

   
}
