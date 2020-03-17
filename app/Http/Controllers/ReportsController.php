<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\DaysModel;
use App\ReportsModel;
use App\ClientModel;
use App\User_info;
use Carbon\Carbon; 
class ReportsController extends Controller
{
   
    public function index(Request $request)
    {
        
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
        
           
        if($request->client !=""){
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
                                   ->join('settings as set', 'set.id', '=', 'id_setting');
                                  
           

            if($request->client != "all"){
             
                $reports->where('uclt.id_client',"=", $request->client);
               
            }

        } else{
            $now = Carbon::now();
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
                                   ->join('settings as set', 'set.id', '=', 'id_setting');
                                  
            
        } 


        $data=$reports->paginate(5);
        // dd($data);
        if ($request->ajax()) {
            return view('reports.incidents', ["data"=>$data]);
        }

        return view('reports.index', ["menu"=>$menu, "days"=>$days, "reports" => $data, "clients" => $clients, "operators" => $operators]);
        }else{
            return redirect('/');
        }
    }

   
}
