<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplyFor extends Model
{
    use HasFactory;
    protected $table = "apply_for";
    protected $fillable = [
        'application_id','user_id','status' , 'cv' ,'created_at','updated_at'
    ];
    public $timestamps = true;

}
