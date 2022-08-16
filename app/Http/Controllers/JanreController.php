<?php

namespace App\Http\Controllers;

use App\Models\Janre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JanreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data = Janre::all();
        
        $subset = $data->map(function($value){
            return $value->only(['id' ,'name','describtion']);
        });
        
        return $this->SuccessResponce($subset);
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
        $validator = Validator::make($request->all() , [
            "name"=>"required",
            "describtion"=>"required"
        ]); 
        if($validator->fails()){
            return $this->ErrorResponce($validator->errors()->first());
        }
        
        Janre::create([      
            "name"=>$request->name,
            "describtion"=>$request->describtion   
        ]);
        return $this->SuccessResponce("Successfully created!");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $janre = Janre::where('id' , $id)->get( );
        
        return $this->SuccessResponce($janre->load('books'));
        
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
    public function upbeat(Request $request){
        $id = $request->id;
        
        $validator = Validator::make($request->all() , [
            "name"=>"required",
            "describtion"=>"required"
        ]); 
        if($validator->fails()){
            return $this->ErrorResponce($validator->errors()->first());
        }
        $janre = Janre::where('id' , $id)->get();
        if(empty($janre[0])){
         return $this->ErrorResponce(["message"=>"Not found"] , 404);   
        }else{
            
        Janre::where('id' , $id)->update([
            "name"=>$request->name,
            "describtion"=>$request->describtion
        ]);
        return $this->SuccessResponce("Successfully updated!");
        
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Janre::where('id', $id)->delete();
        return $this->SuccessResponce("Successfully deleted!");
    
    }
}
