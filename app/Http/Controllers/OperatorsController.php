<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\User_info;
use App\User_client;
use App\ClientModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class OperatorsController extends Controller
{
    public function index(Request $request)
    {           
        $user = Auth::user();
        $id_menu=3;
        $menu = menu($user,$id_menu);
        if($menu['validate']){  
        
            $search = trim($request->dato);


            if(strlen($request->type) > 0 &&  strlen($search) > 0){
                $data2 = User_info::select('users_info.name', 'users_info.phone', 'users_info.emergency_contact_phone', 'users_info.birthdate', 'usr.email', 'usr.id', 'usr.id_status')
                ->join('users as usr', 'users_info.id_user', '=', 'usr.id')
                ->where('usr.id_type_user', 9)
                ->whereIn('usr.id_status', [1,2])
                ->where($request->type,'LIKE','%'.$search.'%');
            } else{
                $data2 = User_info::select('users_info.name', 'users_info.phone', 'users_info.emergency_contact_phone', 'users_info.birthdate', 'usr.email', 'usr.id', 'usr.id_status')
                ->join('users as usr', 'users_info.id_user', '=', 'usr.id')
                ->where('usr.id_type_user', 9)
                ->whereIn('usr.id_status', [1,2]);
            } 
            $data=$data2->paginate(10);
            if ($request->ajax()) {
                return view('operators.table', ["data"=>$data]);
            }

            $clients = ClientModel::whereIn('status', [1,2])->get();
         
            
        return view('operators.index',["menu"=>$menu, "data"=>$data, "clients"=>$clients]);
        }else{
            return redirect('/');
        }
    }

    public function validateForm($request,$user=''){
        $user=='' ? $email = 'required|email|unique:users,email,NULL,id,id_status,1 | unique:users,email,'.$user.',id,id_status,2' :  $email = 'sometimes|required|unique:users,email,'.$user.',id,id_status,1 | unique:users,email,'.$user.',id,id_status,2';
        $this->validate(request(), [
            'name' => 'required|max:150|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
            'last_name' => 'required|max:150|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
            'phone' => 'required|max:20|regex:/^[0-9]{0,20}(\.?)[0-9]{0,2}$/',
            'gender' => 'required',
            'emergency_contact_name' => 'sometimes|max:150|nullable|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
            'emergency_contact_phone' => 'sometimes|nullable|regex:/^[0-9]{0,20}(\.?)[0-9]{0,2}$/',
            'birthdate' => 'required|date|before:18 years ago',
            'nickname' => 'required',
            'email' => $email,
            'password' => 'sometimes|required|confirmed|min:8',
            'image' => 'image',
            'id_client' => 'required',
        ]);
    }

    public function validateNickname($nickname, $user=""){
        $validaNick = User::where('nickname',$nickname)
        ->whereNotIn('id', [$user])
        ->whereIn('id_status', [1,2])
        ->exists();
        return $validaNick;
    }

    public function store(Request $request){
        //VALIDADOR DE FORMULARIO
        OperatorsController::validateForm($request);
        //VALIDAR NICK NAME
        $validaNick = OperatorsController::validateNickname($request->nickname);
        
        if($validaNick){
            $msg= 'Another user already has that Nickname';
            $data=['No'=>2,'msg'=>$msg];
            return response()->json($data);
        }
        //CREAR USUARIO
        $user =  User::Create([
            'id_type_user'=>9,
            'id_status'=>1,
            'nickname'=>$request->nickname,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        // SUBIR IMAGE
        $imageName = OperatorsController::documents($request, "operators");
        if($imageName == null){
            $imageName = ['name'=>"", 'path'=>""];
        }
        // GUARDAR INFO DE USUARIO
        $User_info =  User_info::Create([
            'id_user'=>$user->id,
            'name'=>$request->name,
            'last_name'=>$request->last_name,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'emergency_contact_name'=>$request->emergency_contact_name,
            'emergency_contact_phone'=>$request->emergency_contact_phone,
            'description'=>$request->description,
            'gender'=>$request->gender,
            'birthdate'=>$request->birthdate,
            'profile_picture'=>$imageName['name'],
            'path_image'=>$imageName['path'],
            'biotime_status'=>"",
            'access_code'=>"",
            'entrance_date'=>$request->entrance_date,
        ]);

        // GUARDAR DETALLE CLIENTE
        $user_client = User_client::Create([
            'id_user'=>$user->id,
            'id_client'=>$request->id_client
        ]);
        // GET ROW
        $result = OperatorsController::getResult($user->id);

        return response()->json($result);

    }

    public function show($id){
        $data = User_client::select('cl.id as id_client', 'users_info.name', 'users_info.last_name', 'users_info.address', 'users_info.phone', 'users_info.emergency_contact_name', 'users_info.emergency_contact_phone', 'users_info.description', 'users_info.gender', 'users_info.birthdate',  'users_info.profile_picture as image', 'users_info.entrance_date', 'usr.email', 'usr.nickname', 'usr.id', 'usr.id_status')
            ->join('clients as cl', 'users_client.id_client', '=', 'cl.id')
            ->join('users as usr', 'users_client.id_user', '=', 'usr.id')
            ->join('users_info as users_info', 'users_client.id_user', '=', 'users_info.id_user')
            ->where('usr.id', $id)
            ->first();
        return response()->json($data);
    }

    public function update(Request $request, $id){

        //BUSCA Y ACTUALIZA USER
        $user = User::find($id);
        //VALIDADOR DE FORMULARIO
        OperatorsController::validateForm($request, $id);
        //VALIDAR NICK NAME
        $validaNick = OperatorsController::validateNickname($request->nickname, $id);
        
        if($validaNick){
            $msg= 'Another user already has that Nickname';
            $data=['No'=>2,'msg'=>$msg];
            return response()->json($data);
        }

        $user->nickname = $request->nickname;
        // $user->email = $request->email;
        
        if($request->password != null)
        {
            $user->password = Hash::make($request->password);
        }    
        $user->update();

        //BUSCA Y ACTUALIZA INFO USER
        $user_info = User_info::where('id_user', $user->id)->first();

        if($request->file('image')) {
            $file_path = public_path().'/images/operators/'.$user_info->profile_picture;
            File::delete($file_path);
            $image = $request->file('image');
            $name = time().$image->getClientOriginalName();
            $image->move(public_path().'/images/operators/',$name);
            $path = '/images/operators/'.$name;
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
        $user_info->gender = $request->gender;
        $user_info->birthdate = $request->birthdate;
        $user_info->entrance_date = $request->entrance_date;

        $user_info->update();

        //BUSCA Y ACTUALIZA DETALLE USER_CLIENT
        User_client::where('id_user', $id)->delete();
        $user_client = User_client::Create([
            'id_user'=>$id,
            'id_client'=>$request->id_client
        ]);


        $result = OperatorsController::getResult($user->id);

        return response()->json($result);
    }

    public function getResult($id){
        $data = User_info::select('users_info.name', 'users_info.phone', 'users_info.emergency_contact_phone', 'users_info.birthdate', 'usr.email', 'usr.id', 'usr.id_status')
            ->join('users as usr', 'users_info.id_user', '=', 'usr.id')
            ->where('usr.id_type_user', 9)
            ->where('usr.id', $id)
            ->first();
        return $data;
    }

    //save document
    public function documents($request, $folder){
        
        $imageName = '';
        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = time().$image->getClientOriginalName();
            $image->move(public_path().'/images/'.$folder.'/',$imageName);
            $path = '/images/'.$folder.'/'.$imageName;
            $data =  ["name"=>$imageName, "path"=>$path];
            return $data;

         }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if($user->id_status == 2)
        {
            $user->id_status = 1;
        }
        else
        {
            $user->id_status = 2;  
        }
        $user->save();

        $result = OperatorsController::getResult($id);

        return response()->json($result);
    } 

    public function delete($id)
    {
        $user = User::find($id);
        $user->id_status = 0;
        $user->save();
    
        $result = OperatorsController::getResult($id);

        return response()->json($result);
    } 
}
