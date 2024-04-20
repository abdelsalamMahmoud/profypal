<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $table = "applications";
    protected $fillable = [
        'company_id','title' , 'description' ,'requirements', 'location' , 'flag' ,'created_at','updated_at'
    ];
    public $timestamps = true;

    public function company(){
        return $this->belongsTo('App\Models\Company','company_id','id');
    }

    public function users(){
        return $this->belongsToMany('App\Models\User','apply_for','application_id','user_id','id','id');
    }

}
