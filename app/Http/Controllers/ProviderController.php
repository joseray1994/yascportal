<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ProviderModel;


class ProviderController extends Controller
{
    public function index(Request $request)
    {       
        $user = Auth::user();
        
        $id_menu=5;
        $menu = menu($user,$id_menu);
        if($menu['validate']){   

                $search = trim($request->dato);

                if(strlen($request->type) > 0 &&  strlen($search) > 0){
                    $data2 = ProviderModel::whereNotIn('status',[0])->where($request->type,'LIKE','%'.$search.'%')->paginate(10);
                } else{
                    $data2 = ProviderModel::whereNotIn('status',[0])->paginate(10);
                } 
                $data=$data2;
                if ($request->ajax()) {
                    return view('providers.table', ["data"=>$data]);

                }

                  return view('providers.index',["data"=>$data,"menu"=>$menu,]);
        }else{
            return redirect('/');
        }
            
    }

    public function validateProvider($request){
        
        $this->validate(request(), [
            'id_department' => 'required',
            'name' => 'required|max:60',
            'rfc' => 'required',
            'phone' => 'required|max:12|regex:/^[0-9]{0,20}(\.?)[0-9]{0,2}$/',
            'email' => 'required|email',
        ]); 
    }

    public function ValidateExtraProvider($request,$provider_id){
        $ExtraProviderValidation=[]; 
        $n ="";
        $r ="";
        $p ="";
        $e ="";
        $data = [];

        $name = ProviderModel::where('name', $request->name)
        ->whereIn('status', [1,2]);

        $rfc = ProviderModel::where('rfc', $request->rfc)
        ->whereIn('status', [1,2]);

        $phone = ProviderModel::where('phone', $request->phone)
        ->whereIn('status', [1,2]);

        $email = ProviderModel::where('email', $request->email)
        ->whereIn('status', [1,2]);

        if($provider_id > 0){
            $name->where('id','!=',$provider_id);
        }

        if($provider_id > 0){
            $rfc->where('id','!=',$provider_id);
        }

        if($provider_id > 0){
            $phone->where('id','!=',$provider_id);
        }

        if($provider_id > 0){
            $email->where('id','!=',$provider_id);
        }
            
        $nameV = $name->count();
        $rfcV = $rfc->count();
        $phoneV = $phone->count();
        $emailV = $email->count();

        if($nameV > 0){      
            $n = 'Another user type already has that Name';
            
        }
        if($rfcV > 0){      
            $p = 'Another user type already has that RFC';
            
        }
        if($phoneV > 0){      
            $p = 'Another user type already has that Phone';
            
        }
        if($emailV > 0){      
            $e = 'Another user type already has that Email';
            
        }

        if($n==''  && $r=='' && $p=='' && $e==''){
            $data=[];

          }else{
              $data=[
                  'No' =>2,
                  'name'=>$n,
                  'rfc'=>$r,
                  'phone'=>$p,
                  'email'=>$e,
                ];

              array_push($ExtraProviderValidation,$data);
          }
        return $ExtraProviderValidation;
    }
     
    public function store(Request $request)
    {      
             
        $answer=ProviderController::ValidateExtraProvider($request,0);
      
        if($answer){

              return response()->json($answer);

        }else{

            $provider_id="";
            ProviderController::validateProvider($request,$provider_id);
            $provider = ProviderModel::firstOrCreate(['id_department'=>$request->id_department,
            'name'=>$request->name,
            'rfc'=>$request->rfc,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'status'=>1,]);

            return response()->json($provider);
        }
    }

    public function update(Request $request, $provider_id)
    {
        $answer=ProviderController::ValidateExtraProvider($request,0);
  
        if(ProviderController::ValidateExtraProvider($request,$provider_id)){

            return response()->json($answer);

        }else{

            ProviderController::validateProvider($request,$provider_id);
            
            $provider = providerModel::find($provider_id);
            $provider->name = $request->name;
            $provider->rfc = $request->rfc;
            $provider->phone = $request->phone;
            $provider->email = $request->email;
            $provider->status=1;
            $provider->save();
            return response()->json($provider);
        }
    }

    public function show($provider_id)
    {

        $provider = ProviderModel::find($provider_id);
        $provider->status=1;
        return response()->json($provider);
    }

    public function destroy($provider_id)
    {
        $provider = ProviderModel::find($provider_id);
        if($provider->status == 2)
        {
            $provider->status = 1;
        }
        else
        {
            $provider->status = 2;  
        }
        $provider->save();

        return response()->json($provider);
    } 

    public function delete($provider_id)
    {
        $provider = providerModel::find($provider_id);
            $provider->status = 0;
            $provider->save();
      
        return response()->json($provider);
    } 

}
