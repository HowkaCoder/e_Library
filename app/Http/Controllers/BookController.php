<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data = Book::all();
        
        $subset = $data->map(function($value){
            return $value->only(['id' ,'author_id','janre_id','name','describtion' , 'img' , 'file']);
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
            "author_id"=>"required|exists:App\Models\Author,id",
            "janre_id"=>"required|exists:App\Models\Janre,id",
            "describtion"=>"required"
        ]); 
        if($validator->fails()){
            return $this->ErrorResponce($validator->errors()->first());
        }
        if(!empty($request->img)){
            $img = time().'_'.$request->file('img')->getClientOriginalName();
            // $this->img_compress($main_img);
            $request->file('img')->storeAs('public/images/books', $img);
            $img_path = public_path()."\storage\images\books\\".$img;
            $img_path = str_replace('\\' , '/' , $img_path);
                 
        } else{
            $img_path = null;
        }
        if(!empty($request->file)){
            $file = time().'_'.$request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public/books',$file);
            $file_path = public_path()."\storage\books\\".$file;
            $file_path = str_replace('\\' , '/' , $file_path);
        }else{
            $file_path = null;
        }
        Book::create([
            "name"=>$request->name,
            "author_id"=>$request->author_id,
            "janre_id"=>$request->janre_id,
            "describtion"=>$request->describtion,
            "img"=>$img_path,
            "file"=>$file_path
        ]);
        return $this->SuccessResponce("Book successfully created!");
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::where('id' , $id)->get( );
        
        return $this->SuccessResponce($book->load('janre')->load('author'));
        

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
        Book::where('id' , $id)->delete();
        return $this->SuccessResponce('Successfully deleted!!!!');
    }
    
    public function upbeat(Request $request){
        $id = $request->id;
        
        $validator = Validator::make($request->all() , [
            "name"=>"required",
            "author_id"=>"required|exists:App\Models\Author,id",
            "janre_id"=>"required|exists:App\Models\Janre,id",
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
            $img_path = public_path()."\storage\images\authors\\".$img;
            $img_path = str_replace('\\' , '/' , $img_path);
                 
        } else{
            $img_path = null;
        }
        
        if(!empty($request->file)){
            $file = time().'_'.$request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public/books',$file);
            $file_path = public_path()."\storage\books\\".$file;
            $file_path = str_replace('\\' , '/' , $file_path);

        }else{
            $file_path = null;
        }
        $book = Book::where('id' , $id)->get();
        if(empty($book[0])){
         return $this->ErrorResponce(["message"=>"Not found"] , 404);   
        }else{
        Book::where('id' , $id)->update([
            "name"=>$request->name,
            "author_id"=>$request->author_id,
            "janre_id"=>$request->janre_id,
            "describtion"=>$request->describtion,
            "img"=>$img_path,
            "file"=>$file_path
        ]);
        return $this->SuccessResponce("Successfully updated!");
        }
        
    }
}
