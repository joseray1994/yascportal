<?php

use App\BasicMenuModel;
use App\User;
use App\User_info;
use App\AssignamentTypeModel;
use App\ActionModel;
use App\TimeClockModel;
use App\BaDetailModel;
use App\IncidentReportModel;
use Illuminate\Support\Facades\Auth;
use App\TypeUserModel;

if (!function_exists('menu')) {
 
   
    function menu($user,$id_menu)
    {
        $usertypes = TypeUserModel::where('id',$user->id_type_user)->where('status',1)->count(); 

        if($usertypes == 1 && $user->id_status == 1){

            $shift_status = TimeClockModel::where('id_operator',$user->id)->where('status',1)->exists();

            $incident = IncidentReportModel::where('id_user', $user->id)->where('status', 1)->exists();

            $valaccess=AssignamentTypeModel::where('id_type_user',$user->id_type_user)->where('id_menu',$id_menu)->where('status',1)->exists();

            $tu_detail=AssignamentTypeModel::where('id_type_user',$user->id_type_user)->where('id_menu',$id_menu)->where('status',1)->first();

            $menuUser = AssignamentTypeModel::select('tu_detail.id_menu as id_menu','bm.name as name', 'bm.icon as icon', 'bm.link as link', 'tu_detail.status as status', 'tu_detail.id_type_user as id_tu')
            ->join('basic_menu as bm', 'bm.id', '=', 'tu_detail.id_menu')
            ->where('tu_detail.status', 1)
            ->where('tu_detail.id_type_user',  $user->id_type_user)
            ->orderBy('bm.prioridad')
            ->get();

            $menuNum = AssignamentTypeModel::select('tu_detail.id_menu as id_menu','bm.name as name', 'bm.icon as icon', 'bm.link as link', 'tu_detail.status as status', 'tu_detail.id_type_user as id_tu')
            ->join('basic_menu as bm', 'bm.id', '=', 'tu_detail.id_menu')
            ->where('tu_detail.status', 1)
            ->where('tu_detail.id_type_user',  $user->id_type_user)
            ->count();

            $bas = BaDetailModel::where('id_tu_detail',$tu_detail->id)->get();

            $type = TypeUserModel::where('id',$user->id_type_user)->where('status',1)->first();

            $dataUser = User_info::select('path_image')->where('id',$user->id)->first();
            
            $menu=[
              'menuUser'=>$menuUser,
              'validate'=>$valaccess,
              'menuNum'=>$menuNum,
              'typeuser'=>$type,
              'dataUser'=>$dataUser,
              'actions'=>$bas,
              'shift'=>$shift_status,
              'incident'=>$incident
            ];
        }else{
               
            $menu=[
                'menuUser'=>"",
                'menuNum'=>0,
                'validate'=>false,
                'privada'=>$user->privada_id,
                'typeuser'=>$user->user_type_id,
              ]; 
        }
            return $menu;
    }


    function lote($user,$id_menu)
    {
            $valaccess=AssignamentTypeModel::where('id_type_user',$user->user_type_id)->where('id_menu',$id_menu)->where('status',1)->count();
            return $valaccess;
    }
}