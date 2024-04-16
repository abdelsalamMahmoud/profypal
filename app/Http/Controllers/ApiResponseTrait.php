<?php

namespace App\Http\Controllers;

trait ApiResponseTrait
{
    public function apiResponse($data = null ,$message = null,$status = null){

        $array=[
            'data'=>$data,
            'massage'=> $message,
            'status'=> $status,
        ];
        return response($array);
    }

}
