<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = "posts";
    protected $fillable = [
       'user_id', 'body' , 'image' , 'num_of_likes','created_at','updated_at'
    ];
    public $timestamps = true;

}
