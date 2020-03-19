<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\CandidateModel;
use App\VacancyModel;
use App\DocumentModel;

class CandidateController extends Controller
{

    public function search_settings($type){
        $result='';

        switch ($type) {

            case 'name':
                $result='candidates.name';
                break;
            case 'mail':
                $result='candidates.mail';
                break;
            
            default:
               $result='';
                break;

        }
        return $result;
    }
    
    public function index(Request $request, $id)
    {           
      
        $user = Auth::user();
        
        $id_menu=5;
        $menu = menu($user,$id_menu);
        if($menu['validate']){   

            $vacancy = VacancyModel::where('id', $id)->get();

                $search = trim($request->dato);

                if(strlen($request->type) > 0 &&  strlen($search) > 0){
                    $type= CandidateController::search_settings($request->type);

                    $data2 = CandidateModel::select('candidates.id as id',  'vac.name as name_vacancy', 'candidates.name as name', 'candidates.last_name as last_name', 'candidates.phone as phone', 
                    'candidates.mail as mail', 'candidates.channel as channel', 
                    'candidates.listening_test as listening_test', 'candidates.grammar_test as grammar_test', 
                    'candidates.typing_test as typing_test', 'candidates.typing_test2 as typing_test2',  'candidates.typing_test3 as typing_test3',  'candidates.typing_test4 as typing_test4','candidates.status as status')
                    ->join('vacancies as vac', 'vac.id', '=', 'candidates.id_vacancy')
                    ->where('candidates.id_vacancy',$id)
                    ->whereNotIn('candidates.status',[0])
                    ->where($type,'LIKE','%'.$search.'%');

                

                  
                } else{
                    $data2 = CandidateModel::select('candidates.id as id',  'vac.name as name_vacancy', 'candidates.name as name', 'candidates.last_name as last_name', 'candidates.phone as phone', 
                    'candidates.mail as mail', 'candidates.channel as channel', 
                    'candidates.listening_test as listening_test', 'candidates.grammar_test as grammar_test', 
                    'candidates.typing_test as typing_test', 'candidates.typing_test2 as typing_test2',  'candidates.typing_test3 as typing_test3',  'candidates.typing_test4 as typing_test4','candidates.status as status')
                    ->join('vacancies as vac', 'vac.id', '=', 'candidates.id_vacancy')
                    ->where('candidates.id_vacancy',$id)
                    ->whereNotIn('candidates.status',[0]);
                  
                    
                } 
                $data=$data2->paginate(10);
                if ($request->ajax()) {
                    return view('candidates.table', ["data"=>$data]);
                }
  
                return view('candidates.index',["data"=>$data, "vacancies"=>$vacancy, "menu"=>$menu]);
        }else{
            return redirect('/');
        }
            
    }

    public function resultdata($id){

        $candidate = CandidateModel::select('candidates.id as id',  'vac.name as name_vacancy', 'candidates.name as name', 'candidates.last_name as last_name', 'candidates.phone as phone', 
        'candidates.mail as mail', 'candidates.channel as channel', 
        'candidates.listening_test as listening_test', 'candidates.grammar_test as grammar_test', 
        'candidates.typing_test as typing_test', 'candidates.typing_test2 as typing_test2',  'candidates.typing_test3 as typing_test3',  'candidates.typing_test4 as typing_test4','candidates.status as status')
        ->join('vacancies as vac', 'vac.id', '=', 'candidates.id_vacancy')
        ->where('candidates.id',$id)
        ->first();

        return $candidate;
    }


    public function validateCandidate($request, $candidate_id){
        //$user=='' ? $email = 'required|email|unique:users,email,NULL,id,id_status,1 | unique:users,email,'.$user.',id,id_status,2' :  $email = 'sometimes|required|unique:users,email,'.$user.',id,id_status,1 | unique:users,email,'.$user.',id,id_status,2';
        $this->validate(request(), [
           'id_vacancy' => 'required',
            'name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'phone' => 'required|max:12|regex:/^[0-9]{0,20}(\.?)[0-9]{0,2}$/|unique:candidates,phone,'.$candidate_id,
            'mail' => 'required|email|unique:candidates,mail,'.$candidate_id,
            'channel' => 'required',
            'listening_test' => 'required',
            'grammar_test' => 'required',
            'typing_test' => 'required|max:3',
            'typing_test2' => 'required|max:3',
            'typing_test3' => 'required|max:3',
            'typing_test4' => 'required|max:3',
        ]); 
       
    }

    public function store(Request $request)
    {      
            $candidate_id="";
            CandidateController::validateCandidate($request,$candidate_id);
            $candidate = CandidateModel::firstOrCreate([
           'id_vacancy'=>$request->id_vacancy,
            'name'=>$request->name,
            'last_name'=>$request->last_name,
            'phone'=>$request->phone,
            'mail'=>$request->mail,
            'channel'=>$request->channel,
            'listening_test'=>$request->listening_test,
            'grammar_test'=>$request->grammar_test,
            'typing_test'=>$request->typing_test,
            'typing_test2'=>$request->typing_test2,
            'typing_test3'=>$request->typing_test3,
            'typing_test4'=>$request->typing_test4,
            'status'=>1,]);

            $id=$candidate->id;

            $candidate2 = CandidateController::resultdata($id);

            return response()->json($candidate2);
      
    }

    public function show($id, $candidate_id)
    {

        $candidate = CandidateModel::find($candidate_id);
        $candidate->status=1;
        return response()->json(["candidates" => $candidate, "flag" => 2]);
    }

    
    public function detail($id, $candidate_id)
    {

        $candidate = CandidateModel::find($candidate_id);
        $candidate->status=1;
        return response()->json(["candidates" => $candidate, "flag" => 3]);
    }

    public function update(Request $request, $id,$candidate_id)
    {
       
            CandidateController::validateCandidate($request,$candidate_id);
            $candidate = CandidateModel::find($candidate_id);
            $candidate->id_vacancy = $request->id_vacancy;
            $candidate->name = $request->name;
            $candidate->last_name = $request->last_name;
            $candidate->phone = $request->phone;
            $candidate->mail = $request->mail;
            $candidate->channel = $request->channel;
            $candidate->listening_test = $request->listening_test;
            $candidate->grammar_test = $request->grammar_test;
            $candidate->typing_test = $request->typing_test;
            $candidate->typing_test2 = $request->typing_test2;
            $candidate->typing_test3 = $request->typing_test3;
            $candidate->typing_test4 = $request->typing_test4;
            $candidate->status=1;
            $candidate->save();

            $id=$candidate->id;

            $candidate2 = CandidateController::resultdata($id);

            return response()->json($candidate2);
        
    }
    
    public function destroy($id, $candidate_id)
    {
        $candidate = CandidateModel::find($candidate_id);
        if($candidate->status == 2)
        {
            $candidate->status = 1;
        }
        else
        {
            $candidate->status = 2;  
        }
        $candidate->save();

        $id=$candidate->id;

        $candidate2 = CandidateController::resultdata($id);

        return response()->json($candidate2);
    } 

    public function delete($id, $candidate_id)
    {
        $candidate = CandidateModel::find($candidate_id);
        $candidate->status=0;
        $candidate->save();

        return response()->json($candidate);

    } 

}
