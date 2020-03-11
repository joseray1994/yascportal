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
                    ->where($request->type,'LIKE','%'.$search.'%')
                    ->paginate(5);

                  
                } else{
                    $data2 = CandidateModel::select('candidates.id as id',  'vac.name as name_vacancy', 'candidates.name as name', 'candidates.last_name as last_name', 'candidates.phone as phone', 
                    'candidates.mail as mail', 'candidates.channel as channel', 
                    'candidates.listening_test as listening_test', 'candidates.grammar_test as grammar_test', 
                    'candidates.typing_test as typing_test', 'candidates.status as status')
                    ->join('vacancies as vac', 'vac.id', '=', 'candidates.id_vacancy')
                    ->where('candidates.id_vacancy',$id)
                    ->whereNotIn('candidates.status',[0])
                    ->paginate(5);
                    
                } 
                $data=$data2;
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
        if($candidate_id==""){
        $this->validate(request(), [
           'id_vacancy' => 'required',
            'name' => 'required|unique:candidates|max:30',
            'last_name' => 'required|max:30',
            'phone' => 'required|unique:candidates|max:12',
            'mail' => 'required|unique:candidates',
            'channel' => 'required',
            'listening_test' => 'required',
            'grammar_test' => 'required',
        ]); 
        }else{
            $this->validate(request(), [
               'id_vacancy' => 'required',
                'name' => 'required|max:30',
                'last_name' => 'required|max:30',
                'mail' => 'required',
                'channel' => 'required',
                'listening_test' => 'required',
                'grammar_test' => 'required',
                
            ]);   
        }
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
        return response()->json(["candidates" => $candidate, "flag" => 1]);
    }


    
    public function update(Request $request, $id, $candidate_id)
    {

        $candidateValidation = CandidateModel::where('name', $request->name)
        ->whereIn('status', [1,2])
        ->first(); 
    

        if($candidateValidation == null){
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
        }
        else{
            $candidate2='Otra Vacante ya cuenta con ese Nombre.';
            return response()->json($candidate2);
        }
       
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

       //Functions for Documents
       public function documents($request, $folder){
        if ($request->file('document')) {
            $count = count($request->file('document'));
            $documentName = '';
            $document = $request->file('document');
            $arrayNames = array();
            for($i=0; $i<$count; $i++){
              
                $documentName = time().$document[$i]->getVacancyOriginalName();
                $document[$i]->move(public_path().'/documents/'.$folder.'/',$documentName);
                $path = '/documents/'.$folder.'/'.$documentName;
                
                $array = [
                    'name' => $documentName,
                    'path' => $path
                ];
                array_push($arrayNames,$array);

                }
            return $arrayNames;
         }
       
    }

    public function storeDocuments(Request $request, $id, $candidate_id){
     dd($candidate_id);

       $names = CandidateController::documents($request, "candidates");
       foreach($names as $name){
        dd($name);
        $document = DocumentModel::create([
            'id_dad'=> $candidate_id,
            'mat'=> 'CAD',
            'name'=> $name['name'],
            'path'=> $name['path']
            ]);

       }
    
       return response()->json(["success" => "Data inserted correctly"]);

    }
    
    public function showDocuments($id, $candidate_id)
    {  
        dd($candidate_id);
        $document = DocumentModel::where('id_dad', $candidate_id)->where('mat', 'CAD')->get();
        return response()->json(["documents" => $document, "flag" => 2]);
        
    }
}
