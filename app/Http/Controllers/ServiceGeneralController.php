<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\User_info;
use App\DocumentModel;
use App\SettingsModel;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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
            
        } 
        if(!$result){
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
        }  
        return response()->json($result);


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

    public function showDocument($id, $mat){
        $document = DocumentModel::where('id_dad', $id)->where('mat', $mat)->where('status', 1)->get();
        return response()->json(["document" => $document, "flag" => 1]);
    }

    public function validateDoc($request){
        
        $this->validate(request(), [
            'document' => 'required',
            'document.*' => 'required|file|max:5000|mimetypes:application/pdf,application/msword,application/vnd.ms-powerpoint,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/doc,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/zip,image/jpeg,image/png',
        ]);
    }

    public function storeDocument(Request $request, $id, $mat){
        
        $names = ServiceGeneralController::documents($request, $mat);
        $arrayId = array();
        $arrayDocuments = array();
        foreach($names as $name){
         // dd($name);
            $document = DocumentModel::create([
                'id_dad'=> $id,
                'mat' => $mat,
                'name'=> $name['name'],
                'path'=> $name['path']
            ]);
            
            array_push($arrayId, $document->id);
        }

        foreach($arrayId as $ids){
            $doc = ServiceGeneralController::getRowDocs($ids);
            array_push($arrayDocuments, $doc);
        }
        // dd($arrayDocuments);
        $msg= 'Data inserted correctly';
        $data=['No'=>3,'msg'=>$msg, 'id'=> $id, 'documents'=>$arrayDocuments];
        return response()->json($data);
 
    }

    public function getRowDocs($id){
        $document = DocumentModel::find($id);
        return $document;
    }
    //Functions for Documents
    public function documents($request, $folder){
        // dd($request->file('document'));
        ServiceGeneralController::validateDoc($request);
        if ($request->file('document')) {
            $count = count($request->file('document'));
            $documentName = '';
            $document = $request->file('document');
            $arrayNames = array();
            for($i=0; $i<$count; $i++){
              
                $documentName = time().$document[$i]->getClientOriginalName();
                $document[$i]->move(public_path().'/documents/'.$folder.'/',$documentName);
                $path = '/documents/'.$folder.'/'.$documentName;
                
                $array = [
                    'name' => $documentName,
                    'path' => $path
                ];
                array_push($arrayNames,$array);

                }
            return $arrayNames;
         }
       
    }

    public function deleteDocuments($id)
    { 
        $document = DocumentModel::find($id);
        $document->status = 0;
        $document->save();
  
        return response()->json(['flag'=>4, 'data'=>$document]);
        
    }

    
    public function download($id, $mat) {
        $name = DocumentModel::select('name')->where('id', $id)->first();
        $file = public_path('documents'). '/' . $mat . '/' . $name->name;
        return response()->download($file);
        
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

    public function getReason(){
        $setting = SettingsModel::where('id_option', 2)->get();
        return response()->json($setting);
    }

    public function getSupervisor(){
        $supervisor = User_info::select('users.id', 'Users_info.name')
        ->join('users', 'Users_info.id_user', '=', 'users.id')
        ->whereIn('id_type_user', [2,5])->get();
        return response()->json($supervisor);
    }

}
