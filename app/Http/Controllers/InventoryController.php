<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SupplyModel;
use App\ProviderModel;
use App\TypeUserModel;

class InventoryController extends Controller
{
    public function index(Request $request)
    {           
      
        $user = Auth::user();
        
        $id_menu=16;
        $menu = menu($user,$id_menu);
        if($menu['validate'] && $user->id_type_user==1){  

                $provider = ProviderModel::all();

                $search = trim($request->dato);

                if(strlen($request->type) > 0 &&  strlen($search) > 0){
                 
                    $data2 = SupplyModel::select('supplies.id as id', 'supplies.mat as mat', 'typeuser.name as name_dep', 
                    'prov.name as name_prov','supplies.name as name','supplies.quantity as quantity', 'supplies.price as price', 'supplies.cost as cost', 
                    'supplies.total_price as total_price', 'supplies.status as status')
                    ->join('type_user as typeuser', 'typeuser.id', '=', 'supplies.id_department')
                    ->join('providers as prov', 'prov.id', '=', 'supplies.id_provider')
                    ->whereNotIn('supplies.status',[0])
                    ->where($request->type,'LIKE','%'.$search.'%');
                  
                } else{
                    $data2 = SupplyModel::select('supplies.id as id', 'supplies.mat as mat', 'typeuser.name as name_dep', 
                    'prov.name as name_prov','supplies.name as name','supplies.quantity as quantity', 'supplies.price as price', 'supplies.cost as cost', 
                    'supplies.total_price as total_price', 'supplies.status as status')
                    ->join('type_user as typeuser', 'typeuser.id', '=', 'supplies.id_department')
                    ->join('providers as prov', 'prov.id', '=', 'supplies.id_provider')
                    ->whereNotIn('supplies.status',[0]);
                  
                } 
                $data=$data2->paginate(10);
                if ($request->ajax()) {
                    return view('inventory.table', ["data"=>$data]);
                }
  
                return view('inventory.index',["data"=>$data, "providers"=>$provider, "menu"=>$menu]);
        }else{
            return redirect('/');
        }
            
    }

    
    public function resultdata($id){

        $inventory = SupplyModel::select('supplies.id as id', 'supplies.mat as mat', 'typeuser.name as name_dep', 
        'prov.name as name_prov','supplies.name as name','supplies.quantity as quantity', 'supplies.price as price', 'supplies.cost as cost', 
        'supplies.total_price as total_price', 'supplies.status as status')
        ->join('type_user as typeuser', 'typeuser.id', '=', 'supplies.id_department')
        ->join('providers as prov', 'prov.id', '=', 'supplies.id_provider')
        ->where('supplies.id',$id)
        ->first();

        return  $inventory;
    }

    public function validateInventory($request){
              
        $this->validate(request(), [
            'name' => 'required|max:60',
            'quantity' => 'required|numeric|min:0|max:999999',
            'price' => 'required|numeric|min:0|max:999999',
            'cost' => 'required|numeric|min:0|max:999999',
            'total_price' => 'required',
        ]); 
    }

    public function ValidateExtraInventory($request,$supply_id){
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
    
    public function show($id)
    {
        $inventory = SupplyModel::select('supplies.id as id', 'supplies.mat as mat', 'typeuser.name as name_dep', 
        'prov.name as name_prov','supplies.name as name','supplies.quantity as quantity', 'supplies.price as price', 'supplies.cost as cost', 
        'supplies.total_price as total_price', 'supplies.status as status')
        ->join('type_user as typeuser', 'typeuser.id', '=', 'supplies.id_department')
        ->join('providers as prov', 'prov.id', '=', 'supplies.id_provider')
        ->where('supplies.id',$id)
        ->first();

        return response()->json(["inventory" => $inventory, "flag" => 1]);

    }

    public function showProv($id)
    {
        $inventory = SupplyModel::select('supplies.id as id', 'supplies.mat as mat', 'typeuser.name as name_dep', 
        'prov.name as name_prov', 'prov.id as id_provider','supplies.name as name','supplies.quantity as quantity', 'supplies.price as price', 'supplies.cost as cost', 
        'supplies.total_price as total_price', 'supplies.status as status')
        ->join('type_user as typeuser', 'typeuser.id', '=', 'supplies.id_department')
        ->join('providers as prov', 'prov.id', '=', 'supplies.id_provider')
        ->where('supplies.id',$id)
        ->first();

        return response()->json(["inventory" => $inventory, "flag" => 2]);

    }


    public function update(Request $request, $supply_id)
    {
        $var = count(InventoryController::ValidateExtraInventory($request,$supply_id));
        $answer=InventoryController::ValidateExtraInventory($request,0);
      
        if($var>0){

              return response()->json($answer);

        }else{

            InventoryController::validateInventory($request);
            $inventory = SupplyModel::find($supply_id);
            $inventory->name = $request->name;
            $inventory->quantity = $request->quantity;
            $inventory->price = $request->price;
            $inventory->cost = $request->cost;
            $inventory->total_price = $request->total_price;
            if($inventory->quantity == 0){
                $inventory->status = 2;
            }
            $inventory->save();

            $id=$inventory->id;

            $inventory2 = InventoryController::resultdata($id);

            return response()->json($inventory2);
        }
            
    }

    public function updateProv(Request $request, $supply_id)
    {
        $inventory = SupplyModel::find($supply_id);
        $inventory->id_provider = $request->id_provider2;
        $inventory->save();
      
        $id=$inventory->id;

        $inventory2 = SupplyModel::select('supplies.id as id', 'supplies.mat as mat', 'typeuser.name as name_dep', 
        'prov.name as name_prov', 'prov.id as id_provider','supplies.name as name','supplies.quantity as quantity', 'supplies.price as price', 'supplies.cost as cost', 
        'supplies.total_price as total_price', 'supplies.status as status')
        ->join('type_user as typeuser', 'typeuser.id', '=', 'supplies.id_department')
        ->join('providers as prov', 'prov.id', '=', 'supplies.id_provider')
        ->where('supplies.id',$id)
        ->first();

        return response()->json($inventory2);
    }

    public function destroy($supply_id)
    {
        $inventory = SupplyModel::find($supply_id);
        if($inventory->status == 2)
        {
            $inventory->status = 1;
        }
        else
        {
            $inventory->status = 2;  
        }
        $inventory->save();

        $id=$inventory->id;

        $inventory2 = InventoryController::resultdata($id);

        return response()->json($inventory2);

    }  

        
    public function delete($supply_id)
    {
        $inventory = SupplyModel::find($supply_id);
        $inventory->status=0;
        $inventory->save();

        return response()->json($inventory);

    } 
}
