<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public $img_path;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Author::all();
        
        $subset = $data->map(function($value){
            return $value->only(['id' ,'name','describtion' , 'img']);
        });
        
        return $this->SuccessResponce($subset);
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
        
        if(!empty($request->img)){
            $img = time().'_'.$request->file('img')->getClientOriginalName();
            $path = public_path();
            // $this->img_compress($main_img);
            $request->file('img')->storeAs('public/images/authors', $img);
            $path = public_path()."\storage\images\authors\\".$img;
            $this->path = str_replace('\\' , '/' , $path);

        } else{
            $this->img_path = null;
        }
        Author::create([
            "name"=>$request->name,
            "describtion"=>$request->describtion,
            "img"=>$this->path 
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
        $author = Author::where('id' , $id)->get( );
        
        return $this->SuccessResponce($author->load('books'));
        

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
        Author::where('id', $id)->delete();
        return $this->SuccessResponce("Successfully deleted!");
    
    }

    public function upbeat(Request $request ){
        $id = $request->id;
        
        $validator = Validator::make($request->all() , [
            "name"=>"required",
            "describtion"=>"required"
        ]); 
        if($validator->fails()){
            return $this->ErrorResponce($validator->errors()->first());
        }
        if(!empty($request->img)){
            $img = time().'_'.$request->file('img')->getClientOriginalName();
            $path = public_path();
            // $this->img_compress($main_img);
            $request->file('img')->storeAs('public/images/authors', $img);
            $path = public_path()."\storage\images\authors\\".$img;
            $path = str_replace('\\' , '/' , $path);

                 
        } else{
            $img = null;
        }
        $author = Author::where('id' , $id)->get();
        if(empty($author[0])){
         return $this->ErrorResponce(["message"=>"Not found"] , 404);   
        }else{
        Author::where('id' , $id)->update([
            "name"=>$request->name,
            "describtion"=>$request->describtion,
            "img"=>$path   
        ]);
        return $this->SuccessResponce("Successfully updated!");
        }

    }

}
