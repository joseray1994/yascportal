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
                $data = ZoomModel::select('id', 'name', 'email', 'password', 'in_use_by', 'status')->where($type,'LIKE','%'.$search.'%')->where('status', '!=', 0)->orderBy('id');
            } 
            else{
                $data = ZoomModel::select('id', 'name', 'email', 'password', 'in_use_by', 'status')->where('status', '!=', 0)->orderBy('id');
                                        
            } 

             $zoom=$data->paginate(10);
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

    public function validateZoom($request, $zoom_id = ''){
       
        $this->validate(request(), [
            'name' => 'unique:zoom,name,'.$zoom_id,
            'email' => 'unique:zoom,email,'.$zoom_id,
           
        ]); 
    }

    public function getResult($zoom_id){
        $data =  ZoomModel::select('id', 'name', 'email', 'password', 'in_use_by', 'status')->orderBy('id')->where('id', $zoom_id)->where('status', '!=', 0)->first();;
        return $data;
    }

 
    public function store(Request $request)
    {
    
        ZoomController::validateZoom($request);
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

   
    public function show($zoom_id)
    {
            $zoom = ZoomModel::where('id', $zoom_id)->where('status', '!=', 0)->first();
        return response()->json(["zoom" => $zoom, "flag" => 1]);
    }

    
    public function edit($id)
    {
        //
    }

  
    public function update(Request $request, $zoom_id)
    {   
        ZoomController::validateZoom($request, $zoom_id);
        $zoom = ZoomModel::where('id',$zoom_id)->first();
      
        $zoom->name = $request['name'];
        $zoom->email = $request['email'];
        $zoom->password = $request['password'];
        $zoom->save();

        $id_zoom = $zoom->id;
        $name = $zoom->name;
        $result = $this->getResult($id_zoom);
        return response()->json(['zoom' => $result, 'flag' => 1, 'zoom_update' => "The zoom $name has been updated successfully"]);
    }

    public function destroy($id)
    {
        // dd($id);
         $zoom = ZoomModel::select('id', 'name', 'email', 'password', 'in_use_by', 'status')->where('id',$id)->where('status', '!=', 0)->first();

        if($zoom->status == 2)
        {
            $zoom->status = 1;
        }
        else
        {
            $zoom->status = 2;  
        }
        $zoom->save();

        return response()->json(['zoom' => $zoom, 'flag' => 1]);
    } 

    public function delete($id)
    {
            $zoom = ZoomModel::where('id',$id)->first();
            $zoom->status = 0;
            $zoom->save();

            $result = $this->getResult($id);
            $name = $zoom->name;
        return response()->json(['zoom'=>$result, 'flag' => 1, 'zoom_deleted' => "The zoom $name has been deleted" ]);
    } 

    
    public function assign_user(Request $request, $id)
    {
        $id_user = $request['id_user'];

        $user = User::select('info.name as name', 'info.last_name as last_name')
                    ->join('users_info as info', 'info.id_user', '=', 'users.id')
                    ->where('users.id', $id_user)
                    ->first();
                      
        $name = $user->name.' '.$user->last_name;
        $zoom = ZoomModel::where('id',$id)->first();
        $zoom->in_use_by = $name;
        $zoom->status = 3;
        $zoom->save();

        $id_zoom = $zoom->id;
        $zoom_name = $zoom->name;
        $result = $this->getResult($id_zoom);
        return response()->json(['zoom'=>$result,'flag' => 2, 'user_update' => "The zoom $zoom_name is used by $name"]);
    }

   public function quit_user(Request $request, $id){
    //    dd($id);
        $zoom = ZoomModel::where('id',$id)->first();
        $zoom->in_use_by = null;
        $zoom->status = 1;
        $zoom->save();

        $id_zoom = $zoom->id;
        $zoom_name = $zoom->name;
        $result = $this->getResult($id_zoom);
        return response()->json(['zoom'=>$result,'flag' => 3, 'user_update' => "The zoom $zoom_name is available"]);
   }
}
