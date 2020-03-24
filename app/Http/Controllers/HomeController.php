<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\NewsModel;
use App\LikesModel;
use App\CommentsModel;
use App\UserViewsNewsModel;
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
        
        $id_menu=13;
        $menu = menu($user,$id_menu);
        if($menu['validate']){ 
            $data = NewsModel::select('id', 'title','description', 'news_picture', 'path', 'created_at')
            ->whereIn('status', [1,2])
            ->latest()
            ->get();
            return view('dashboard.index',["menu"=>$menu, "data"=>$data]);
        }
    }

}
