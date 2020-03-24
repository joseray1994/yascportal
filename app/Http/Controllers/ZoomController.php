<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\User_info;
use Illuminate\Support\Facades\Auth;
use App\ZoomModel;

class ZoomController extends Controller
{
    public function search_zoom($type){
        $result='';

        switch ($type) {
            case 'id':
                $result='id';
                break;
            case 'name':
                $result='name';
                break;
            
            default:
               $result='';
                break;

        }
        return $result;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        $id_menu=13;
        $menu = menu($user,$id_menu);
        if($menu['validate']){   
            $search = trim($request->dato);
            // dd($request);
            if(strlen($request->type) > 0 &&  strlen($search) > 0){

                $type= ZoomController::search_zoom($request->type);
                $data = ZoomModel::select('id', 'name', 'email', 'password', 'in_use_by', 'status')->where($type,'LIKE','%'.$search.'%')->orderBy('id');
            } 
            else{
                $data = ZoomModel::select('id', 'name', 'email', 'password', 'in_use_by', 'status')->orderBy('id');
                                        
            } 

             $zoom=$data->paginate(5);
                if ($request->ajax()) {
                    return view('zoom.table', ["zoom"=>$zoom]);

                }
                $users = User::select('users.id as id', 'info.name as name', 'info.last_name')
                            ->join('users_info as info', 'info.id_user', '=', 'users.id')
                            ->where('users.id_type_user', 3)
                            ->get();
                  return view('zoom.index',["menu"=>$menu, "users" => $users, "zoom" => $zoom]);
        }else{
            return redirect('/');
        }
    }

    public function validateClient($request, $client_id = ''){
       
        $this->validate(request(), [
            'name' => 'unique:clients,name,'.$client_id.'|required|max:30|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
            'color' => 'unique:clients,color,'.$client_id,
            'time_zone' => 'required',
            'interval' => 'required|max:2',
            'duration' => 'required|max:3'
        ]); 
    }

    public function getResult($zoom_id){
        $data =  ZoomModel::select('id', 'name', 'email', 'password', 'in_use_by', 'status')->orderBy('id')->where('id', $zoom_id)->first();;
        return $data;
    }

 
    public function store(Request $request)
    {
    
        // ZoomController::validateClient($request);
        $data = $request->input();
        // dd($data);
        $zoom = ZoomModel::firstOrCreate([
        'name'=>$data['name'],
        'email'=>$data['email'],
        'password'=>$data['password'],
    
        ]);

        $id_zoom = $zoom->id;
         $result = $this->getResult($id_zoom);
         $name = $zoom->name;
        return response()->json(['zoom' => $result, 'flag' => 1, 'zoom_success' =>"The zoom $name has been saved successfully"]);

    }

    public function assign_user(Request $request, $id)
    {
        dd($id);
    }

    public function create()
    {
        //
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

  
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
