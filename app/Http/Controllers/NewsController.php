<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\NewsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $id_menu=12;
        $menu = menu($user,$id_menu);

        if($menu['validate']){  

            $search = trim($request->dato);


            if(strlen($request->type) > 0 &&  strlen($search) > 0){
                $data2 = NewsModel::select('news.id', 'news.title', 'users_info.name', 'users_info.last_name', 'news.created_at', 'news.status')
                ->join('users_info', 'news.id_user', '=', 'users_info.id_user')
                ->whereIn('news.status', [1,2])
                ->where('news.'.$request->type,'LIKE','%'.$search.'%')
                ->latest();
            } else{
                $data2 = NewsModel::select('news.id', 'news.title', 'users_info.name', 'users_info.last_name', 'news.created_at', 'news.status')
                ->join('users_info', 'news.id_user', '=', 'users_info.id_user')
                ->whereIn('news.status', [1,2])
                ->latest();
            } 
            $data=$data2->paginate(10);
            if ($request->ajax()) {
                return view('news.table', ["data"=>$data]);
            }
            return view('news.index',["menu"=>$menu, "data"=>$data]);
            
        }else{
            return redirect('/');
        }
    }

    public function validateForm($request){
        $this->validate(request(), [
            'title' => 'required',
            'description' => 'required',
            'news_picture' => 'sometimes|nullable|image',
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        NewsController::validateForm($request);

        // SUBIR IMAGE
        $imageName = NewsController::documents($request, "news");
        if($imageName == null){
            $imageName = ['name'=>"", 'path'=>""];
        }
        $news = NewsModel::Create([
            "id_user"=>$user->id,
            "title"=>$request->title,
            "description"=>$request->description,
            "news_picture"=>$imageName['name'],
            "path"=>$imageName['path'],
        ]);

        $result = NewsController::getResult($news->id);
        return response()->json($result);
    }

    public function getResult($id){
        $row = NewsModel::select('news.id', 'news.title', 'users_info.name', 'users_info.last_name', 'news.created_at', 'news.status', 'news.news_picture', 'news.path', 'news.description')
        ->join('users_info', 'news.id_user', '=', 'users_info.id_user')
        ->where('news.id', $id)
        ->first();
        return $row;
    }

    
    //save document
    public function documents($request, $folder){
        
        $imageName = '';
        if ($request->file('news_picture')) {
            $image = $request->file('news_picture');
            $imageName = time().$image->getClientOriginalName();
            $image->move(public_path().'/images/'.$folder.'/',$imageName);
            $path = '/images/'.$folder.'/'.$imageName;
            $data =  ["name"=>$imageName, "path"=>$path];
            return $data;
         }
    }

    public function update(Request $request, $id)
    {
        $news = NewsModel::find($id);
        if($request->file('news_picture')) {
            $file_path = public_path().'/images/news/'.$news->news_picture;
            File::delete($file_path);
            $image = $request->file('news_picture');
            $name = time().$image->getClientOriginalName();
            $image->move(public_path().'/images/news/',$name);
            $path = '/images/news/'.$name;
            $news->path = $path;
            $news->news_picture = $name;
        }elseif($request->flag_hidden == "true"){
            $file_path = public_path().'/images/news/'.$news->news_picture;
            File::delete($file_path);
            $news->path = "";
            $news->news_picture = "";
        }else
        {
            $news->path = $news->path;
            $news->news_picture = $news->news_picture;
        }

        $news->title = $request->title;
        $news->description = $request->description;
        $news->update();
        
        $result = NewsController::getResult($news->id);
        return response()->json($result);
    }

    public function destroy($id)
    {
        $news = NewsModel::find($id);
        if($news->status == 2)
        {
            $news->status = 1;
        }
        else
        {
            $news->status = 2;  
        }
        $news->save();

        $result = NewsController::getResult($id);
        return response()->json($result);
    } 

    public function delete($id)
    {
        $news = NewsModel::find($id);
        $news->status = 0;
        $news->save();
    
        $result = NewsController::getResult($id);
        return response()->json($result);
    } 
}
