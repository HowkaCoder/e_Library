<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
class Author extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function books(){
        return $this->hasMany(Book::class  )->select(['id' , 'author_id','janre_id','name' , 'describtion' , 'img' , 'file']);
    }
}
