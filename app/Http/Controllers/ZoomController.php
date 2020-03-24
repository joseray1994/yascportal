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
                $data = ZoomModel::where($type,'LIKE','%'.$search.'%')->orderBy('zoom.id');
            } 
            else{
                $data = ZoomModel::orderBy('zoom.id');
                                        
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

    public function assign_user($zoom_id)
    {
        dd($zoom_id);
    }

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
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
