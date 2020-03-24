<?php

namespace App\Http\Controllers;
use App\User;
use App\SuspendedModel;
use Illuminate\Http\Request;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Auth;

class SuspendedWorkController extends Controller
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
        if($menu['validate']){          
        
                $search = trim($request->dato);

                if(strlen($request->type) > 0 &&  strlen($search) > 0){
                    $data2 = SuspendedModel::whereNotIn('status',[0])->where($request->type,'LIKE','%'.$search.'%')->paginate(10);
                } else{
                    $data2 = SuspendedModel::whereNotIn('status',[0])->paginate(10);
                } 
                $data=$data2;
                if ($request->ajax()) {
                    return view('types.table', ["data"=>$data]);
                }
            
        return view('types.index',["data"=>$data,"menu"=>$menu,]);
        }else{
            return redirect('/');
        }
    }
    public function data_suspended($id){

        $data = SuspendedModel::select('schedule_suspended.id as id','schedule_suspended.date_start as dateS','schedule_suspended.date_end as dateE','schedule_suspended.created_at as created','schedule_suspended.status as status','inf.name as name','inf.last_name as lname')
        ->join('users_info as inf','inf.id_user', "=", 'schedule_suspended.id_operator')
        ->where('schedule_suspended.id',$id)
        ->first();
        return $data;
    }
    public function validateSuspended($request){
        
            $this->validate(request(), [
                'date_start' => 'required|date',
                'date_end' => 'required|date|after:date_start',
                'operator' => 'required',
            ]); 
        }
    
    public function store(Request $request)
    {   
    
            SuspendedWorkController::validateSuspended($request);
            $suspended= SuspendedModel::Create([
                "id_operator"=>$request->operator,
                "date_start"=>$request->date_start,
                "date_end"=>$request->date_end,
            ]);
          
            $suspended2 = SuspendedWorkController::data_suspended($suspended->id);
            $data=['No'=>4,'suspended'=>$suspended2]; 

             return response()->json($data);
    }
      
           
  
    public function show($suspended_id)
    {

        $suspended = SuspendedWorkController::data_suspended($suspended_id);  
        $suspended->status=1;
        $data=['No'=>2,'suspended'=>$suspended];
        return response()->json($data);
    }

    public function update(Request $request, $suspended_id)
    {
       
            SuspendedWorkController::validateSuspended($request,$suspended_id);
            $suspended = SuspendedModel::find($suspended_id);
            $suspended->date_start = $request->date_start;
            $suspended->date_end = $request->date_end;
            $suspended->status=1;
            $suspended->save();
            $suspended2 = SuspendedWorkController::data_suspended($suspended->id);

            $data=['No'=>4,'suspended'=>$suspended2];
            
            return response()->json($data);
    }

    public function destroy($suspended_id)
    {
        $suspended = SuspendedModel::find($suspended_id);
        if($suspended->status == 2)
        {
            $suspended->status = 1;
        }
        else
        {
            $suspended->status = 2;  
        }
        $suspended->save();
        $suspended2 = SuspendedWorkController::data_suspended($suspended->id);
        $data=['No'=>2,'suspended'=>$suspended2];  
        return response()->json($data);
    } 

    public function delete($suspended_id)
    {
        $suspended = SuspendedModel::find($suspended_id);
            $suspended->status = 0;
            $suspended->save();
        $data=['No'=>2,'suspended'=>$suspended];
        return response()->json($data);
    } 
}
