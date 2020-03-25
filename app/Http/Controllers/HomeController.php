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
use ConsoleTVs\Profanity\Facades\Profanity;
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
            $data = NewsModel::select('id', 'title','description', 'news_picture', 'path', 'status', 'created_at')
            ->whereIn('status', [1,2])
            ->latest()
            ->get();

            $arrLikes = array();
            $arrComments = array();

            foreach ($data as $new) {
                $countLikes = LikesModel::where('id_news', $new->id)->count();
                array_push($arrLikes, ["id_news"=>$new->id, "likes"=>$countLikes]);
            }

            foreach ($data as $new) {
                $countComments = CommentsModel::where('id_news', $new->id)->count();
                array_push($arrComments, ["id_news"=>$new->id, "comments"=>$countComments]);
            }

            return view('dashboard.index',["menu"=>$menu, "data"=>$data, "likes"=>$arrLikes, "comments"=>$arrComments]);
        }
    }

    public function addLike(Request $request){
        $user = Auth::user();
        $like = LikesModel::Create([
            "id_user"=>$user->id,
            "id_news"=>$request->id
        ]);
        return response()->json($like);
    }

    public function getComments(Request $request){
        $comments = CommentsModel::select('comments.id', 'comments.comment', 'comments.created_at', 'users.nickname', 'usr.path_image')
        ->join('users_info as usr', 'comments.id_user', 'usr.id_user')
        ->join('users', 'usr.id_user', 'users.id')
        ->where('id_news', $request->id)->where('status', 1)->get();
        return response()->json($comments);
    }

    public function addComment(Request $request){
        // $dictionary = resourse_path().'/lang/BadWordsFilter.json';
        $user = Auth::user();

        $comment = CommentsModel::Create([
            "id_news"=>$request->id,
            "id_user"=>$user->id,
            "comment"=>$request->comment
        ]);
        
        return response()->json($comment);

        // Profanity::blocker($request->comment)->dictionary($dictionary)->filter();
    }

}
