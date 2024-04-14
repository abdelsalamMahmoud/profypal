<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $table = "applications";
    protected $fillable = [
        'company_id','title' , 'description' , 'location' , 'flag' ,'created_at','updated_at'
    ];
    public $timestamps = true;

}
