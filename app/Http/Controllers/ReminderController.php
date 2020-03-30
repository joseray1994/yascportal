<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\ReminderModel;
use App\ClientModel;
use App\User_info;
use App\ReminderDetailModel;

class ReminderController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        
        $id_menu=14;
        $menu = menu($user,$id_menu);
        if($menu['validate']){   
            // dd($user);
                // $search = trim($request->dato);

                // if(strlen($request->type) > 0 &&  strlen($search) > 0){
                //     $data2 = VacancyModel::whereNotIn('status',[0])->where($request->type,'LIKE','%'.$search.'%')->paginate(10);
                // } else{
                //     $data2 = VacancyModel::whereNotIn('status',[0])->paginate(10);
                // } 
                // $data=$data2;
                // if ($request->ajax()) {
                //     return view('vacancies.table', ["data"=>$data]);

                // }

                  return view('reminder.index',["menu"=>$menu,]);
        }else{
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
