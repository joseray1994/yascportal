<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\User;
use App\User_info;
use App\TypeUserModel;
use App\ClientModel;
use App\User_client;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $id_menu=5;
        $menu = menu($user,$id_menu);
        $types = TypeUserModel::whereNotIn('id',[9])->get(); 
        $clients = ClientModel::all();
        if($menu['validate']){ 

            // $search = trim($request->dato);

            // if(strlen($request->type) > 0 &&  strlen($search) > 0){
            //     $data2 = User::with('User_info')->paginate(10);
            // } else{
            //     $data2 = User::with('User_info')->paginate(10);
            // } 
            // $data=$data2;
            // if ($request->ajax()) {
            //     return view('users.table', compact('data'));
            // }
            // return view('users.index',compact('data'));
            return view('dashboard.index',["menu"=>$menu]);
        }
    }
}
