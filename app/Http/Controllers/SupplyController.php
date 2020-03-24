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

    public function validateSupply($request){
        
        $this->validate(request(), [
           'id_department' => 'required',
           'id_provider' => 'required',
            'name' => 'required|max:50',
            'quantity' => 'required',
            'price' => 'required',
            'cost' => 'required',
            'total_price' => 'required',
            
        ]); 
       
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
 
    public function store(Request $request)
    {      
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
            dd($supply2);
        return response()->json($supply2);
      
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
