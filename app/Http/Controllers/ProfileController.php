<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 
use App\User_info;
use App\User;
use App\DocumentModel;
use App\User_client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;



class ProfileController extends Controller
{
    public function index(Request $request)
    {           
        $user = Auth::user();
        $id_menu=10;
        $menu = menu($user,$id_menu);
        if($menu['validate']){  

            $profile = User_info::select('users_info.name', 'users_info.last_name', 'users_info.address', 'users_info.phone', 'users_info.emergency_contact_phone', 'users_info.emergency_contact_name', 'users_info.description', 'users_info.profile_picture', 'users_info.birthdate', 'usr.email', 'usr.id', 'usr.id_status', 'usr.nickname')
            ->join('users as usr', 'users_info.id_user', '=', 'usr.id')
            ->where('usr.id', $user->id)
            ->first();

            switch ($menu['typeuser']->id) {
                case 3:
                    $mat = "TDO";
                break;
                case 5:
                    $mat = "IDO";
                break;
                case 7:
                    $mat = "HDO";
                break;
                case 9:
                    $mat = "ODO";
                break;
                case 1:
                    $mat = "ADM";
                break;
                
                default:
                    $mat = "USR";
                break;
            }

            $docs = ProfileController::showDocument($user->id, $mat);
         
        return view('profile.index',["menu"=>$menu, "data"=>$profile, "docs"=>$docs, "mat"=>$mat]);
        }else{
            return redirect('/');
        }
    }

    public function validateForm($request,$user=''){
        $this->validate(request(), [
            'name' => 'required|max:150|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
            'last_name' => 'required|max:150|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
            'phone' => 'required|max:20|regex:/^[0-9]{0,20}(\.?)[0-9]{0,2}$/',
            'emergency_contact_name' => 'sometimes|max:150|nullable|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
            'emergency_contact_phone' => 'sometimes|nullable|regex:/^[0-9]{0,20}(\.?)[0-9]{0,2}$/',
            'birthdate' => 'required|date|before:18 years ago',
            'nickname' => 'required',
            'password' => 'sometimes|required|confirmed|min:8',
            'image' => 'image',
        ]);
    }

    public function validateNickname($nickname, $user=""){
        $validaNick = User::where('nickname',$nickname)
        ->whereNotIn('id', [$user])
        ->whereIn('id_status', [1,2])
        ->exists();
        return $validaNick;
    }

    public function update(Request $request){
        $user = Auth::user();
        $id = $user->id;
        //BUSCA Y ACTUALIZA USER
        $user = User::find($id);
        //VALIDADOR DE FORMULARIO
        ProfileController::validateForm($request, $id);
        //VALIDAR NICK NAME
        $validaNick = ProfileController::validateNickname($request->nickname, $id);
        
        if($validaNick){
            $msg= 'Another user already has that Nickname';
            $data=['No'=>2,'msg'=>$msg];
            return response()->json($data);
        }

        $user->nickname = $request->nickname;
        
        if($request->password != null)
        {
            $user->password = Hash::make($request->password);
        }    
        $user->update();

        //BUSCA Y ACTUALIZA INFO USER
        $user_info = User_info::where('id_user', $user->id)->first();

        $folder = "";
        if($user->id_type_user == 9){
            $folder = "/operators/";
        }else{
            $folder = "/users/";
        }

        if($request->file('image')) {
            $file_path = public_path().'/images'.$folder.$user_info->profile_picture;
            File::delete($file_path);
            $image = $request->file('image');
            $name = time().$image->getClientOriginalName();
            $image->move(public_path().'/images'.$folder,$name);
            $path = '/images'.$folder.$name;
            $user_info->path_image = $path;
            $user_info->profile_picture = $name;
        }else
        {
            $user_info->path_image = $user_info->path_image;
            $user_info->profile_picture = $user_info->profile_picture;
        }

        $user_info->name = $request->name;
        $user_info->last_name = $request->last_name;
        $user_info->address = $request->address;
        $user_info->phone = $request->phone;
        $user_info->emergency_contact_name = $request->emergency_contact_name;
        $user_info->emergency_contact_phone = $request->emergency_contact_phone;
        $user_info->description = $request->description;
        $user_info->birthdate = $request->birthdate;

        $user_info->update();

        $result = ProfileController::getResult($id);
        return response()->json($result);
    }

    public function getResult($id){
        $profile = User_info::select('users_info.name', 'users_info.last_name', 'users_info.address', 'users_info.phone', 'users_info.emergency_contact_phone', 'users_info.emergency_contact_name', 'users_info.description', 'users_info.profile_picture', 'users_info.path_image', 'users_info.birthdate', 'usr.email', 'usr.id', 'usr.id_status', 'usr.nickname')
        ->join('users as usr', 'users_info.id_user', '=', 'usr.id')
        ->where('usr.id', $id)
        ->first();

        return $profile;
    }

    public function showDocument($id, $mat){
        $document = DocumentModel::where('id_dad', $id)->where('mat', $mat)->where('status', 1)->get();
       return $document;
    }

}
