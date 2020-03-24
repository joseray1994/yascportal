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

     
    public function store(Request $request)
    {      
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

    public function update(Request $request, $provider_id)
    {

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
