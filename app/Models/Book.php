<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Author;
use App\Models\Janre;
class Book extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function author(){
        return $this->belongsTo(Author::class)->select('id' , 'name' , 'describtion' , 'img');
    }

    public function janre(){
        return $this->belongsTo(Janre::class)->select('id' , 'name' , 'describtion');
    }
}
