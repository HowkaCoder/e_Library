<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class SearchController extends Controller
{
    public function search(Request $request){
        
        $validator = FacadesValidator::make($request->all() , [
            "name"=>"required"
        ]); 
        if($validator->fails()){
            return $this->ErrorResponce($validator->errors()->first());
        }
        $search = $request->name;
        $data = Book::select(  'books.id as book_id' ,   'books.name as book_name' , 'janres.name as janre_Name' , 'authors.name as author_name' ,  'books.describtion as book_describtion' , 'books.img as img' )
        ->join('janres' , 'janres.id' , 'books.janre_id')
        ->join('authors' , 'authors.id' , 'books.author_id')
        ->where('books.name' , 'LIKE' , "%{$search}%")
        ->orWhere('janres.name' , 'LIKE' , "%{$search}%")
        ->orWhere('authors.name' , 'LIKE' , "%{$search}%")
        ->get();
        return $data;
    }
}
