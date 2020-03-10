<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Auth;
class ServiceGeneralController extends Controller
{
    public function generateNick(Request $request){

        if($request->name == null){
            $msg='Name is Required';
            $data=['No'=>1,'msg'=>$msg];
            return response()->json($data);
        }
        if($request->last_name == null){
            $msg='Last Name is Required';
            $data=['No'=>1,'msg'=>$msg];
            return response()->json($data);
        }

        $name = explode(" ", $request->name);
        $lastname = explode(" ", $request->last_name);

        // VALIDAR QUE ESTEN DISPONIBLES EN LA TABLA USER
        if(count($name) > 1 && count($lastname) > 1){
            $nickname1 = $name[0].$lastname[1];
            $nickname2 = $name[1].$lastname[0];
            $nickname3 = $lastname[0].$name[1];
            $nickname4 = $lastname[1].$name[0];

            $nickname1 = strtolower($nickname1);
            $nickname2 = strtolower($nickname2);
            $nickname3 = strtolower($nickname3);
            $nickname4 = strtolower($nickname4);
            
            $validaNick1 = ServiceGeneralController::validateNickname($nickname1);
            $validaNick2 = ServiceGeneralController::validateNickname($nickname2);
            $validaNick3 = ServiceGeneralController::validateNickname($nickname3);
            $validaNick4 = ServiceGeneralController::validateNickname($nickname4);

            $result = [];

            if(!$validaNick1){
                array_push($result, $nickname1);
            }
            if(!$validaNick2){
                array_push($result, $nickname2);
            }
            if(!$validaNick3){
                array_push($result, $nickname3);
            }
            if(!$validaNick4){
                array_push($result, $nickname4);
            }
            
            return response()->json($result);
            
        }
        elseif(count($name) > 1 && count($lastname) < 2){
            $nickname1 = $name[0].$lastname[0];
            $nickname2 = $lastname[0].$name[0];
            $nickname3 = $name[1].$lastname[0];
            $nickname4 = $lastname[0].$name[1];

            $nickname1 = strtolower($nickname1);
            $nickname2 = strtolower($nickname2);
            $nickname3 = strtolower($nickname3);
            $nickname4 = strtolower($nickname4);
           
            $validaNick1 = ServiceGeneralController::validateNickname($nickname1);
            $validaNick2 = ServiceGeneralController::validateNickname($nickname2);
            $validaNick3 = ServiceGeneralController::validateNickname($nickname3);
            $validaNick4 = ServiceGeneralController::validateNickname($nickname4);

            $result = [];

            if(!$validaNick1){
                array_push($result, $nickname1);
            }
            if(!$validaNick2){
                array_push($result, $nickname2);
            }
            if(!$validaNick3){
                array_push($result, $nickname3);
            }
            if(!$validaNick4){
                array_push($result, $nickname4);
            }
            
            return response()->json($result);
        }
        elseif(count($name) < 2 && count($lastname) > 1){
            $nickname1 = $name[0].$lastname[0];
            $nickname2 = $lastname[0].$name[0];
            $nickname3 = $name[0].$lastname[1];
            $nickname4 = $lastname[1].$name[0];

            $nickname1 = strtolower($nickname1);
            $nickname2 = strtolower($nickname2);
            $nickname3 = strtolower($nickname3);
            $nickname4 = strtolower($nickname4);
           
            $validaNick1 = ServiceGeneralController::validateNickname($nickname1);
            $validaNick2 = ServiceGeneralController::validateNickname($nickname2);
            $validaNick3 = ServiceGeneralController::validateNickname($nickname3);
            $validaNick4 = ServiceGeneralController::validateNickname($nickname4);

            $result = [];

            if(!$validaNick1){
                array_push($result, $nickname1);
            }
            if(!$validaNick2){
                array_push($result, $nickname2);
            }
            if(!$validaNick3){
                array_push($result, $nickname3);
            }
            if(!$validaNick4){
                array_push($result, $nickname4);
            }
            
            return response()->json($result);
        }
        elseif(count($name) < 2 && count($lastname) < 2){
            $nickname1 = $name[0].$lastname[0];
            $nickname2 = $lastname[0].$name[0];

            $nickname1 = strtolower($nickname1);
            $nickname2 = strtolower($nickname2);
            
            $validaNick1 = ServiceGeneralController::validateNickname($nickname1);
            $validaNick2 = ServiceGeneralController::validateNickname($nickname2);

            $result = [];

            if(!$validaNick1){
                array_push($result, $nickname1);
            }
            if(!$validaNick2){
                array_push($result, $nickname2);
            }
            
            return response()->json($result);
        } else{
            //SINO ESTA DISPONIBLE 
            $first_name = str_split($request->name);
            $first_last_name = str_split($request->last_name);
            $nickname1 = $first_name[0].$lastname[0];
            $nickname2 = $name[0].$first_last_name[0];

            $nickname1 = strtolower($nickname1);
            $nickname2 = strtolower($nickname2);

            $validaNick1 = ServiceGeneralController::validateNickname($nickname1);
            $validaNick2 = ServiceGeneralController::validateNickname($nickname2);

            $result = [];

            if(!$validaNick1){
                array_push($result, $nickname1);
            }
            if(!$validaNick2){
                array_push($result, $nickname2);
            }
            
            return response()->json($result);
            
        }  


    }

    public function validateNickname($nickname){
        $validaNick = User::where('nickname',$nickname)
        ->whereIn('id_status', [1,2])
        ->exists();
        return $validaNick;
    }

    public function selectOperatorRefresh($id){
        if($id > 0){
            $ope += User::select('users.id as id', 'ui.name as name', 'ui.last_name as lname')
            ->join('users_info as ui', 'ui.id_user', '=','users.id')
            ->join('users_client as uc','uc.id_user', '=','users.id')
            ->where('users.id_type_user','=',9)
            ->where('uc.id_client',$id)
            ->get();

         }else if($id == "all"){
           $ope += User::select('users.id as id', 'ui.name as name', 'ui.last_name as lname')
            ->join('users_info as ui', 'ui.id_user', '=','users.id')
            ->join('users_client as uc','uc.id_user', '=','users.id')
            ->where('users.id_type_user','=',9)
            ->get();
         }else{
            $ope += User::where('id_type_user',$id)->get();
         }
        
    }

    public function SumTime(Request $request){    
        $m=0;
        $m+= $request->minutes;

        $h=0;
        $h+=$request->hours;
        $now =Carbon::parse($request->time_start);
        
            
            $now->addHours($h)->addMinutes($m);
            $hora = date("H:i", strtotime($now));

        return response()->json($hora);
    }
}
