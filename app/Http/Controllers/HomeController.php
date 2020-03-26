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
use Illuminate\Support\Facades\File;

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

            $arrLikes = array();
            $arrComments = array();
            $arrayNews = array();

            // NEWS QUE PUEDE VER ESTE USUARIO
            $userView = UserViewsNewsModel::select('id_new')
            ->join('news', 'user_view_news.id_new', 'news.id')
            ->where('news.status', 1)
            ->where('id_type_user', $user->id_type_user)->orderBy('id_new', 'desc')->get();
            
            // NEWS
            foreach ($userView as $news) {
                $data = NewsModel::select('news.id', 'news.title','news.description', 'news.news_picture', 'news.path', 'news.status', 'news.created_at', 'users.nickname', 'users_info.path_image')
                ->join('users', 'news.id_user', 'users.id')
                ->join('users_info', 'news.id_user', 'users_info.id_user')
                ->where('status', 1)
                ->orderBy('news.id', 'desc')
                ->where('news.id', $news->id_new)
                ->first();
                array_push($arrayNews, $data);
            }

            // LIKES
            foreach ($arrayNews as $news) {
                $countLikes = LikesModel::where('id_news', $news->id)->count();
                $myLike = LikesModel::where('id_news', $news->id)->where('id_user', $user->id)->exists();
                if($myLike){
                    $flagLike = true;
                }else{
                    $flagLike = false;
                }
                array_push($arrLikes, ["id_news"=>$news->id, "likes"=>$countLikes, "flagLike"=>$flagLike]);
            }

            // COMMENTS
            foreach ($arrayNews as $news) {
                $countComments = CommentsModel::where('id_news', $news->id)->count();
                array_push($arrComments, ["id_news"=>$news->id, "comments"=>$countComments]);
            }

            return view('dashboard.index',["menu"=>$menu, "data"=>$arrayNews, "likes"=>$arrLikes, "comments"=>$arrComments]);
        }
    }

    public function validaLike($id_news, $id_user){
        $validaLike = LikesModel::where('id_news', $id_news)->where('id_user', $id_user)->exists();
        return $validaLike;
    }

    public function addLike(Request $request){
        $user = Auth::user();

        $validaLike = $this->validaLike($request->id, $user->id);
        if($validaLike){
            //DISLIKE
            $like = LikesModel::where('id_news', $request->id)->where('id_user', $user->id)->delete();
            $countLikes = LikesModel::where('id_news', $request->id)->count();
            $data = ["status"=>0, "id_news"=>$request->id, "likes"=>$countLikes];
        }else{
            // LIKE
            $like = LikesModel::Create([
                "id_user"=>$user->id,
                "id_news"=>$request->id
                ]);
            $countLikes = LikesModel::where('id_news', $request->id)->count();
            $data = ["status"=>1, "id_news"=>$request->id, "likes"=>$countLikes];
        }

        return response()->json($data);
    }

    public function getComments(Request $request){
        $comments = CommentsModel::select('comments.id', 'comments.comment', 'comments.created_at', 'users.nickname', 'usr.path_image')
        ->join('users_info as usr', 'comments.id_user', 'usr.id_user')
        ->join('users', 'usr.id_user', 'users.id')
        ->where('id_news', $request->id)->where('status', 1)->get();
        return response()->json($comments);
    }

    public function addComment(Request $request){
        $dictionary = resource_path().'/lang/BadWordsFilter.json';
        $user = Auth::user();

        $comment = Profanity::blocker($request->comment)->dictionary($dictionary)->filter();
        
        $addComment = CommentsModel::Create([
            "id_news"=>$request->id,
            "id_user"=>$user->id,
            "comment"=>$comment
        ]);
        
        return response()->json($addComment);

    }

}
