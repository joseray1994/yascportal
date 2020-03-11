<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\TypeUserModel;
use App\BasicMenuModel;
use App\AssignamentTypeModel;
use App\ClientModel;
use App\ClientColorModel;
use App\ClientContactsModel;
use App\DocumentModel;
use App\BreakRulesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ClientsController extends Controller
{
    public function search_clients($type){
        $result='';

        switch ($type) {
            case 'id':
                $result='clients.id';
                break;
            case 'name':
                $result='clients.name';
                break;
            
            default:
               $result='';
                break;

        }
        return $result;
    }
    
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $id_menu=4;
        $menu = menu($user,$id_menu);
        if($menu['validate']){    
                
            $search = trim($request->dato);
            // dd($request);
            if(strlen($request->type) > 0 &&  strlen($search) > 0){
                $type= ClientsController::search_clients($request->type);

                $data2 = ClientModel::select('clients.id as id', 
                                             'clients.name as name',
                                             'clients.description as description',
                                             'clients.color as id_color',
                                             'clients.status as status',
                                             'brk.interval as interval',
                                             'brk.duration as duration',
                                             'clc.hex as color'
                                             )
                                        ->join('break_rules as brk', 'brk.id_client', '=', 'clients.id')
                                        ->join('client_color as clc', 'clc.id', '=', 'clients.color')
                                        ->whereNotIn('clients.status',[0])
                                        ->orderBy('clients.name')
                                        ->where($type,'LIKE','%'.$search.'%')->paginate(5);
                                  
                                       
                // dd($data2);                        
            } 
            else{
                $data2 = ClientModel::select('clients.id as id', 
                                             'clients.name as name',
                                             'clients.description as description',
                                             'clients.color as id_color',
                                             'clients.status as status',
                                             'brk.interval as interval',
                                             'brk.duration as duration',
                                             'clc.hex as color'
                                             )
                                        ->join('break_rules as brk', 'brk.id_client', '=', 'clients.id')
                                        ->join('client_color as clc', 'clc.id', '=', 'clients.color')
                                        ->whereNotIn('clients.status', [0])
                                        ->orderBy('clients.name')
                                        ->paginate(5);
            } 
           
            $data=$data2;
            $color = ClientColorModel::all(); 
           
            if ($request->ajax()) {
                return view('clients.table', ["data"=>$data]);
            }
       
             return view('clients.index',["data"=>$data,"menu"=>$menu, "color" => $color]);
            
     
        }else{
            return redirect('/');
        }
       
    }
    public function validateClient($request){

        $this->validate(request(), [
            'name' => 'unique:clients|required|max:30|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
            'color' => 'unique:clients'
        ]); 
    }

    public function getResult($client_id){
        $data = ClientModel::select('clients.id as id', 
                                    'clients.name as name',
                                    'clients.description as description',
                                    'clients.color as id_color',
                                    'clients.status as status',
                                    'brk.interval as interval',
                                    'brk.duration as duration',
                                    'clc.hex as color'
                                    )
                            ->join('break_rules as brk', 'brk.id_client', '=', 'clients.id')
                            ->join('client_color as clc', 'clc.id', '=', 'clients.color')
                            ->orderBy('clients.name')
                            ->where('clients.id', $client_id)->first();
        // ClientModel::whereNotIn('status',[0])->where('id', $client_id)->first();
        return $data;
    }

 
    public function store(Request $request)
    {
    
        ClientsController::validateClient($request);
        $data = $request->input();
        $clients = ClientModel::firstOrCreate([
        'name'=>$data['name'],
        'description'=>$data['description'],
        'color'=>$data['color'],
        ]);

        $id_client = $clients->id;

        $breaks = BreakRulesModel::firstOrCreate([
        'interval'=>$data['interval'],
        'duration'=>$data['duration'],
        'id_client'=>$id_client

        ]);
         $result = $this->getResult($id_client);
         $name = $clients->name;
        return response()->json(['client' => $result, 'No' => 1, 'client_success' =>"The client $name has been saved successfully"]);

    }

    public function show($client_id)
    {  
        $client = BreakRulesModel::select('break_rules.id as id', 
                                          'break_rules.id_client as id_client', 
                                          'break_rules.interval as interval', 
                                          'break_rules.duration as duration', 
                                          'clt.name as name', 
                                          'clt.description as description', 
                                          'clt.color as color',
                                          'clc.hex as hex')
                              ->join('clients as clt', 'clt.id', '=', 'break_rules.id_client')
                              ->join('client_color as clc', 'clc.id', '=', 'clt.color')
                              ->where('clt.status', 1)
                              ->where('break_rules.id_client', $client_id)
                              ->orderBy('clt.name')
                              ->first();


       
        return response()->json(["client" => $client, "flag" => 5]);
        
    }

    public function update(Request $request, $client_id)
    {
    //    dd($client_id);
        // TypeUserController::validateType($request,$usertype_id);
        $client = ClientModel::where('id',$client_id)->first();
      
        $client->name = $request['name'];
        $client->description = $request['description'];
        $client->color = $request['color'];
        $client->save();

        $id_client = $client->id;

        $break = BreakRulesModel::where('id_client', $client_id)->first();
        $break->interval = $request['interval'];
        $break->duration = $request['duration'];
        $break->save();
        $name = $client->name;
        $result = $this->getResult($client->id);
        return response()->json(['client' => $result, 'No' => 1, 'client_update' => "The client $name has been updated successfully"]);
    }

    public function destroy($client_id)
    {
        // dd($client_id);
        $client = ClientModel::select('clients.id as id', 
                                        'clients.name as name',
                                        'clients.description as description',
                                        'clients.color as id_color',
                                        'clients.status as status',
                                        'brk.interval as interval',
                                        'brk.duration as duration',
                                        'clc.hex as color'
                                        )
                                ->join('break_rules as brk', 'brk.id_client', '=', 'clients.id')
                                ->join('client_color as clc', 'clc.id', '=', 'clients.color')
                                ->where('clients.status', '!=', 0)
                                ->where('clients.id', $client_id)->first();
        // dd($client);
        if($client->status == 2)
        {
            $client->status = 1;
        }
        else
        {
            $client->status = 2;  
        }
        $client->save();

        return response()->json(['client' => $client, 'flag' => 1]);
    } 

    public function delete($client_id)
    {
            $client = ClientModel::find($client_id);
            $client->status = 0;
            $client->save();

            $result = $this->getResult($client_id);
            $name = $client->name;
        return response()->json(['client'=>$result, 'flag' => 1, 'client_deleted' => "The cliente $name has been deleted" ]);
    } 

     //Functions for Documents
     public function documents($request, $folder){
        if ($request->file('document')) {
            $count = count($request->file('document'));
            $documentName = '';
            $document = $request->file('document');
            $arrayNames = array();
            for($i=0; $i<$count; $i++){
              
                $documentName = $document[$i]->getClientOriginalName();
                $document[$i]->move(public_path().'/documents'.'/',$documentName);
                $path = '/documents/'.$documentName;
                
                $array = [
                    'name' => $documentName,
                    'path' => $path
                ];
                array_push($arrayNames,$array);

                }
            return $arrayNames;
         }
       
    }

    public function storeDocuments(Request $request, $id){
        // dd($id);
        $count = count($request->file('document'));
       $names = ClientsController::documents($request, "clients");
       foreach($names as $name){
        // dd($name);
        $document = DocumentModel::create([
            'id_dad'=> $id,
            'mat' => 'CDO',
            'name'=> $name['name'],
            'path'=> $name['path']
            ]);

       }
    
       return response()->json(["doc_success" => "$count files inserted correctly", "flag"=>3]);

    }

    public function showDocuments($id)
    {  
        // dd($id);
        $document = DocumentModel::where('id_dad', $id)->where('mat', 'CDO')->where('status', 1)->get();
        return response()->json(["document" => $document, "flag" => 3]);
        
    }

    public function deleteDocuments($id)
    { 
         $document = DocumentModel::find($id);
        $document->status = 0;
        $document->save();
  
    return response()->json($document);
        
    }

    public function download($id) {
        // dd($id);
        $name = DocumentModel::select('name')->where('id', $id)->first();
        // dd(public_path());
        $file = public_path('documents'). '/' . $name->name;
        // dd($file_path);
        return response()->download($file);
        
      }

    //Functions for contacts
    public function storeContacts(Request $request)
    {
        $data = $request->input();
        $clients = ClientContactsModel::create([
        'id_client'=>$data['client_id_contacts'],
        'name'=>$data['name_contact'],
        'description'=>$data['description_contact'],
        'phone'=>$data['phone_contact'],
        'email'=>$data['email_contact'],
        ]);
        $id = $clients->id;
        $name = $clients->name;
        $result = $this->getResultContacts($id);
        return response()->json(["contact" => $result, "No" => 2, 'contact_success' => "The contact $name has been saved successfully"]);
    }

    public function getResultContacts($id){
        $data = ClientContactsModel::select('id','name', 'description', 'phone', 'email', 'status')->where('id', $id)->first();
        // ClientModel::whereNotIn('status',[0])->where('id', $client_id)->first();
        return $data;
    }
    public function validateContact($request){

        $this->validate(request(), [
            'name_contact' => 'unique:client_contacts|required|max:30|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
            'phone' => 'required|max:20|regex:/^[0-9]{0,20}(\.?)[0-9]{0,2}$/',
        ]); 
    }

    public function showContacts($id)
    {  
        $contact = ClientContactsModel::where('id_client', $id)->whereNotIn('status',[0])->get();
        return response()->json(["contact" => $contact, "flag" => 2]);
        
    }

    public function editContacts($id)
    {
        $contact_edit = ClientContactsModel::where('id', $id)->first();
        return response()->json(["contact_edit" => $contact_edit, "flag" => 4]);
        
    }

    public function updateContacts(Request $request, $id)
    {
        // dd($request);
        $contact = ClientContactsModel::where('id',$id)->first();
        // dd($contact);
        $contact->name = $request['name_contact'];
        $contact->description = $request['description_contact'];
        $contact->phone = $request['phone_contact'];
        $contact->email = $request['email_contact'];
        $contact->save();
        $id = $contact->id;
        
        $result = $this->getResultContacts($contact->id);
        $name = $contact->name;
        return response()->json(['contact'=>$result, 'No' => 2, 'contact_updated' => "The contact $name has been updated successfully"]);
    }

    public function destroyContacts($id)
    {
        $contact = ClientContactsModel::where('id', $id)->where('status', "!=", 0)->first();
        // dd($contact);
        if($contact->status == 2)
        {
            $contact->status = 1;
        }
        else
        {
            $contact->status = 2;  
        }
        $contact->save();

        return response()->json(['contact' => $contact, 'flag' => 2]);
    } 

    public function deleteContact($id)
    {
            $contact = ClientContactsModel::find($id);
            $contact->status = 0;
            $contact->save();
            $result = $this->getResultContacts($id);
            $name = $contact->name;
        return response()->json(['contact'=>$result, 'flag'=> 2, 'contact_deleted' => "The contact $name has been deleted"]);
    } 


}
