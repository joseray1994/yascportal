<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\VacancyModel;

class VacancyController extends Controller
{

    public function index(Request $request)
    {       
        $user = Auth::user();
        
        $id_menu=5;
        $menu = menu($user,$id_menu);
        if($menu['validate']){   

                $search = trim($request->dato);

                if(strlen($request->type) > 0 &&  strlen($search) > 0){
                    $data2 = VacancyModel::whereNotIn('status',[0])->where($request->type,'LIKE','%'.$search.'%')->paginate(5);
                } else{
                    $data2 = VacancyModel::whereNotIn('status',[0])->paginate(10);
                } 
                $data=$data2;
                if ($request->ajax()) {
                    return view('vacancies.table', ["data"=>$data]);

                }

                  return view('vacancies.index',["data"=>$data,"menu"=>$menu,]);
        }else{
            return redirect('/');
        }
            
    }


    public function validateVacancy($request){
        
        $this->validate(request(), [
            'name' => 'required',
            'description' => 'max:300',
        ]); 
    }

    public function ValidateExtraVacancy($request,$vacancy_id){
        $ExtraVacancyValidation=[]; 
        $n ="";
        $data = [];

        $name = VacancyModel::where('name', $request->name)
        ->whereIn('status', [1,2]);

        if($vacancy_id > 0){
            $name->where('id','!=',$vacancy_id);
        }
            
        $nameV = $name->count();

        if($nameV > 0){      
            $n = 'Another user type already has that Name';
            
        }
        if($n==''){
            $data=[];

          }else{
              $data=[
                  'No' =>2,
                  'name'=>$n,
                ];

              array_push($ExtraVacancyValidation,$data);
          }
        return $ExtraVacancyValidation;
    }
  
    public function store(Request $request)
    {      
        $answer=VacancyController::ValidateExtraVacancy($request,0);
      
        if($answer){

              return response()->json($answer);

        }else{
            $vacancy_id="";
            VacancyController::validateVacancy($request,$vacancy_id);
            $vacancy = VacancyModel::firstOrCreate(['name'=>$request->name,
            'description'=>$request->description,
            'status'=>1,]);

            return response()->json($vacancy);
            
        }
      
    }

    public function update(Request $request, $vacancy_id)
    {

        $var = count(VacancyController::ValidateExtraVacancy($request,$vacancy_id));
        $answer=VacancyController::ValidateExtraVacancy($request,0);
    
        if($var>0){

            return response()->json($answer);

        }else{
     

            VacancyController::validateVacancy($request,$vacancy_id);
            $vacancy = VacancyModel::find($vacancy_id);
            $vacancy->name = $request->name;
            $vacancy->description = $request->description;
            $vacancy->status=1;
            $vacancy->save();
            return response()->json($vacancy);
        }
    }

   
    public function show($vacancy_id)
    {

        $vacancy = VacancyModel::find($vacancy_id);
        $vacancy->status=1;
        return response()->json($vacancy);
    }

    
    public function destroy($vacancy_id)
    {
        $vacancy = VacancyModel::find($vacancy_id);
        if($vacancy->status == 2)
        {
            $vacancy->status = 1;
        }
        else
        {
            $vacancy->status = 2;  
        }
        $vacancy->save();

        return response()->json($vacancy);
    } 

    public function delete($vacancy_id)
    {
        $vacancy = VacancyModel::find($vacancy_id);
            $vacancy->status = 0;
            $vacancy->save();
      
        return response()->json($vacancy);
    } 

}
