<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;
    protected $table = "follows";
    protected $fillable = [
       'following_id','follower_id','status' ,'created_at','updated_at'
    ];
    public $timestamps = true;

}
