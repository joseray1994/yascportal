<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Events\NewMessage;
use Carbon\Carbon;
use App\User;
use App\User_info;
use App\TypeUserModel;
use App\ClientModel;
use App\User_client;
use DB;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $id_menu=5;
        $menu = menu($user,$id_menu);
        $types = TypeUserModel::whereNotIn('id',[9])->get(); 
        $clients = ClientModel::all();
        if($menu['validate']){ 
            $search = trim($request->dato);
            $type = $request->type;
            if(strlen($request->type) > 0 &&  strlen($search) > 0){

                $data2 = User::select('id','email','id_status')
                ->whereHas("User_info",function($q) use ($type,$search){
                    $q->where($type,'LIKE','%'.$search.'%');
                })
                ->with('User_info:id_user,name,last_name,phone,entrance_date,birthdate')
                ->whereIn('id_status', [1,2]);
            } else{
                $data2 = User::select('id','email','id_status')->
                with('User_info:id_user,name,last_name,phone,entrance_date,birthdate')
                ->whereIn('id_status', [1,2]);
            } 
            $data=$data2->paginate(2);
            if ($request->ajax()) {
                return view('users.table', ["data"=>$data]);
            }
            // return view('users.index',compact('data'));
            return view('users.index',["data"=>$data,"menu"=>$menu,'types'=>$types, 'clients'=>$clients]);
        }
    }

    public function clients()
    {
        $clients = ClientModel::all();
        return response()->json($clients);
    }

    public function validateUser($request,$user=''){
        $user=='' ? $email = 'required|unique:users,email,NULL,id,id_status,1 | required|unique:users,email,NULL,id,id_status,2' :  $email = 'sometimes|required|unique:users,email,'.$user.',id,id_status,1 | required|unique:users,email,'.$user.',id,id_status,2';
        // dd($email);
        $this->validate(request(), [
            'name' => 'required|max:40',
            'last_name' => 'required|max:40',
            'phone' => 'max:16',
            'emergency_contact_phone' => 'max:16',
            'emergency_contact_name' => 'max:40',
            'email' => $email,
            'birthdate' => 'date|before:18 years ago',
            'phone' => 'max:20',
            'gender' => 'not_in:0',
            'id_type_user' => 'gt:0',
            'password' => 'sometimes|required|confirmed|min:8',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateUser($request);

        //VALIDAR NICK NAME
        $validaNick = UserController::validateNickname($request->nickname);
        
        if($validaNick){
            $msg= 'Another user already has that Nickname';
            $data=['No'=>2,'msg'=>$msg];
            return response()->json($data);
        }
        try {
            DB::beginTransaction();
                $input = $request->input();
                $input['id_status'] = 1;
                $input['nickname'] = 'nick'.$input['name'];
                $input['password'] = Hash::make($input['password']);
                $user = User::create($input);

                // SUBIR IMAGE
                $imageName = UserController::documents($request, "users");
                
                $input['profile_picture'] = $imageName;
                $input['id_user'] = $user->id;
                $user_info = User_info::create($input);
                
                if($request->clients != null)
                {
                    foreach($request->clients as $id_client)
                    {
                        User_client::create(['id_user'=>$user->id,'id_client'=>$id_client]);
                    }
                }
            DB::commit();
            // event(new NewMessage(User::where('id',$user->id)->with('User_info')->first()));
            return response()->json(User::where('id',$user->id)->with('User_info')->first());
        } catch (\Exception $e) {
            return response()->json($e);    
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return response()->json(User::where('id',$user->id)->with('User_info')->with('clients')->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
        // dd($request);
        $this->validateUser($request,$user->id);
        $user->email == $request->email ? $user->email = $request->email : '';
        $user->id_type_user = $request->id_type_user;
        if($request->password != null)
        {
            $user->password = Hash::make($request->password);
        }
        $user->update();

        
        $user_info = User_info::where('id_user',$user->id)->first();

        if($request->file('image')) {
            $file_path = public_path().'/images/users/'.$user_info->profile_picture;
            File::delete($file_path);
            $image = $request->file('image');
            $name = time().$image->getClientOriginalName();
            $image->move(public_path().'/images/users/',$name);
            $user_info->profile_picture = $name;
        }else
        {
            $user_info->profile_picture = $user_info->profile_picture;
        }
        $user_info->id_user = $user->id;
        $user_info->name = $request->name;
        $user_info->last_name = $request->last_name;
        $user_info->address = $request->address;
        $user_info->gender = $request->gender;
        $user_info->phone = $request->phone;
        $user_info->emergency_contact_phone = $request->emergency_contact_phone;
        $user_info->emergency_contact_name = $request->emergency_contact_name;
        $user_info->notes = $request->notes;
        $user_info->description = $request->description;
        $user_info->update();

        if($request->clients != null)
        {
            User_client::where('id_user',$user->id)->delete();
            foreach($request->clients as $id_client)
            {
                User_client::create(['id_user'=>$user->id,'id_client'=>$id_client]);
            }
        }

        return response()->json(User::where('id',$user->id)->with('User_info')->first());
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
            return $imageName;

         }
    }

    public function validateNickname($nickname){
        $validaNick = User::where('nickname',$nickname)
        ->whereIn('id_status', [1,2])
        ->exists();
        return $validaNick;
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

        $result = User::where('id',$id)->with('User_info')->first();

        return response()->json($result);
    } 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = User::find($id);
        $user->id_status = 0;
        $user->save();
    
        $result = User::where('id',$id)->with('User_info')->first();

        return response()->json($result);
    }
}
