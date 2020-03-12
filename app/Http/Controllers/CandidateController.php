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
    public function index(Request $request, $id)
    {           
        $user = Auth::user();
        
        $id_menu=5;
        $menu = menu($user,$id_menu);
        if($menu['validate']){   

            $vacancy = VacancyModel::where('id', $id)->get();

                $search = trim($request->dato);

                if(strlen($request->type) > 0 &&  strlen($search) > 0){
                    $data2 = CandidateModel::select('candidates.id as id',  'vac.name as name_vacancy', 'candidates.name as name', 'candidates.last_name as last_name', 'candidates.phone as phone', 
                    'candidates.mail as mail', 'candidates.channel as channel', 
                    'candidates.listening_test as listening_test', 'candidates.grammar_test as grammar_test', 
                    'candidates.typing_test as typing_test', 'candidates.status as status')
                    ->join('vacancies as vac', 'vac.id', '=', 'candidates.id_vacancy')
                    ->where('candidates.id_vacancy',$id)
                    ->whereNotIn('candidates.status',[0])
                    ->where($request->type,'LIKE','%'.$search.'%');
                

                  
                } else{
                    $data2 = CandidateModel::select('candidates.id as id',  'vac.name as name_vacancy', 'candidates.name as name', 'candidates.last_name as last_name', 'candidates.phone as phone', 
                    'candidates.mail as mail', 'candidates.channel as channel', 
                    'candidates.listening_test as listening_test', 'candidates.grammar_test as grammar_test', 
                    'candidates.typing_test as typing_test', 'candidates.status as status')
                    ->join('vacancies as vac', 'vac.id', '=', 'candidates.id_vacancy')
                    ->where('candidates.id_vacancy',$id)
                    ->whereNotIn('candidates.status',[0]);
                  
                    
                } 
                $data=$data2->paginate(10);
                if ($request->ajax()) {
                    return view('candidates.table', compact('data'));
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
        'candidates.typing_test as typing_test', 'candidates.status as status')
        ->join('vacancies as vac', 'vac.id', '=', 'candidates.id_vacancy')
        ->where('candidates.id',$id)
        ->first();

        return $candidate;
    }


    public function validateCandidate($request,$candidate_id){
        //dd($request);
        $this->validate(request(), [
           'id_vacancy' => 'required',
            'name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'phone' => 'required|unique:candidates|max:12',
            'mail' => 'required|unique:candidates',
            'channel' => 'required',
            'listening_test' => 'required',
            'grammar_test' => 'required',
        ]); 
       
    }

    public function ValidateUpdateCandidate($request,$candidate_id){
        $ExtraCandidateValidation=[]; 
        $p ="";
        $e ="";
        $data = [];

        $phone = CandidateModel::where('id','!=',$candidate_id)
        ->where('phone',$request->phone)
        ->where('status', [1,2])
        ->count();

        $email = CandidateModel::where('id','!=',$candidate_id)
        ->where('mail',$request->mail)
        ->where('status', [1,2])
        ->count();

            if($phone > 0){      
                $p = 'Another user type already has that Phone';
                
            }
            if($email > 0){      
                $e = 'Another user type already has that Email';
                
            }
           
            if($p=='' && $e==''){
              $data=[];

            }else{
                $data=[
                    'phone'=>$p,
                    'mail'=>$e,
                ];

                array_push($ExtraCandidateValidation,$data);
            }

           
        return $ExtraCandidateValidation;
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

    public function update(Request $request, $candidate_id)
    {
    //     $answer= CandidateController::ValidateUpdateCandidate($request,$candidate_id);
    //   //dd($answer);
    //     if($answer){

    //           return response()->json($answer);

    //       }
        //   else{
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
            $candidate->status=1;
            $candidate->save();

            $id=$candidate->id;

            $candidate2 = CandidateController::resultdata($id);

            return response()->json($candidate2);
        //   }
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
