<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SupplyModel;
use App\ProviderModel;


class SupplyController extends Controller
{

    public function index(Request $request, $id)
    {           
      
        $user = Auth::user();
        
        $id_menu=5;
        $menu = menu($user,$id_menu);
        if($menu['validate']){  

                $provider = ProviderModel::where('id', $id)->get();

                $search = trim($request->dato);

                if(strlen($request->type) > 0 &&  strlen($search) > 0){
                    $type= CandidateController::search_settings($request->type);

                    $data2 = SupplyModel::select('supplies.id as id', 'supplies.mat as mat', 'supplies.id_department as id_department', 
                    'prov.name as name_prov','supplies.name as name','supplies.quantity as quantity', 'supplies.price as price', 'supplies.cost as cost', 
                    'supplies.total_price as total_price', 'supplies.status as status')
                    ->join('providers as prov', 'prov.id', '=', 'supplies.id_provider')
                    ->where('supplies.id_provider',$id)
                    ->whereNotIn('supplies.status',[0])
                    ->where($type,'LIKE','%'.$search.'%');
                  
                } else{
                    $data2 = SupplyModel::select('supplies.id as id', 'supplies.mat as mat', 'supplies.id_department as id_department', 
                    'prov.name as name_prov','supplies.name as name','supplies.quantity as quantity', 'supplies.price as price', 'supplies.cost as cost', 
                    'supplies.total_price as total_price', 'supplies.status as status')
                    ->join('providers as prov', 'prov.id', '=', 'supplies.id_provider')
                    ->where('supplies.id_provider',$id)
                    ->whereNotIn('supplies.status',[0]);
                  
                } 
                $data=$data2->paginate(10);
                if ($request->ajax()) {
                    return view('supplies.table', ["data"=>$data]);
                }
  
                return view('supplies.index',["data"=>$data, "providers"=>$provider, "menu"=>$menu]);
        }else{
            return redirect('/');
        }
            
    }

    public function resultdata($id){

        $supply = SupplyModel::select('supplies.id as id', 
                                    'supplies.mat as mat', 
                                    'supplies.id_department as id_department', 
                                    'prov.name as name_prov','supplies.name as name',
                                    'supplies.quantity as quantity', 'supplies.price as price',
                                    'supplies.cost as cost', 'supplies.total_price as total_price', 
                                    'supplies.status as status')
        ->join('providers as prov', 'prov.id', '=', 'supplies.id_provider')
        ->where('supplies.id',$id)
        ->first();

        return $supply;
    }

    public function validateSupply($request){
        
        $this->validate(request(), [
           'id_department' => 'required',
           'id_provider' => 'required',
            'name' => 'required|max:60',
            'quantity' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'total_price' => 'required',
            
        ]); 
       
    }

    public function ValidateExtraSupply($request,$supply_id){
        $ExtraSupplyValidation=[]; 
        $n ="";
        $data = [];

        $name = SupplyModel::where('name', $request->name)
        ->whereIn('status', [1,2]);

        if($supply_id > 0){
            $name->where('id','!=',$supply_id);
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

              array_push($ExtraSupplyValidation,$data);
          }
        return $ExtraSupplyValidation;
    }
 
    public function store(Request $request)
    {     
        $answer=SupplyController::ValidateExtraSupply($request,0);
      
        if($answer){

              return response()->json($answer);

        }else{

        $supply_id="";
        SupplyController::validateSupply($request,$supply_id);
        $supply = SupplyModel::firstOrCreate([
       'id_department'=>$request->id_department,
       'id_provider'=>$request->id_provider,
        'name'=>$request->name,
        'quantity'=>$request->quantity,
        'price'=>$request->price,
        'cost'=>$request->cost,
        'total_price'=>$request->total_price,
        'status'=>1,]);

        $id=$supply->id;

        $supply2 = SupplyController::resultdata($id);
            
        return response()->json($supply2);
        }
    }

    public function show($id, $supply_id)
    {

        $supply = SupplyModel::find($supply_id);
        $supply->status=1;
        return response()->json($supply);
    }


    public function update(Request $request, $id,$supply_id)
    {
        $var = count(SupplyController::ValidateExtraSupply($request,$supply_id));
        $answer=SupplyController::ValidateExtraSupply($request,0);
      
        if($var>0){

              return response()->json($answer);

        }else{

            SupplyController::validateSupply($request,$supply_id);
            $supply = SupplyModel::find($supply_id);
            $supply->id_department = $request->id_department;
            $supply->id_provider = $request->id_provider;
            $supply->name = $request->name;
            $supply->quantity = $request->quantity;
            $supply->price = $request->price;
            $supply->cost = $request->cost;
            $supply->total_price = $request->total_price;
            $supply->status=1;
            $supply->save();

            $id=$supply->id;

            $supply2 = SupplyController::resultdata($id);

            return response()->json($supply2);
        }
        
    }

    public function destroy($id, $supply_id)
    {
        $supply = SupplyModel::find($supply_id);
        if($supply->status == 2)
        {
            $supply->status = 1;
        }
        else
        {
            $supply->status = 2;  
        }
        $supply->save();

        $id=$supply->id;

        $supply2 = SupplyController::resultdata($id);

        return response()->json($supply2);
    } 

    
    public function delete($id, $supply_id)
    {
        $supply = SupplyModel::find($supply_id);
        $supply->status=0;
        $supply->save();

        return response()->json($supply);

    } 
}
