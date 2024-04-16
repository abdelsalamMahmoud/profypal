<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplyFor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    use ApiResponseTrait;

    public function add_application(Request $request , $company_id){

        $validator = Validator::make($request->all(),[
            'title'=>'required|max:255',
            'description'=>'required|max:255',
            'location'=>'required',
        ]);

        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }

        $application = Application::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'location'=>$request->location,
            'flag'=>'1',
            'company_id'=>$company_id
        ]);

        if($application){
            return $this->apiResponse($application,'application added successfully ',201);
        }
        return $this->apiResponse(null,'this application is not added please try again',400);
    }

    public function acceptProfile($id){
        $apply = ApplyFor::find($id);

        if(!$apply){
            return $this->apiResponse(null,'the application not found',404);
        }

        $apply->update([
            'status'=>'1',
        ]);

        if($apply){
            return $this->apiResponse($apply,'this application accepted',201);
        }
    }

    public function rejectProfile($id){
        $apply = ApplyFor::find($id);

        if(!$apply){
            return $this->apiResponse(null,'the application not found',404);
        }

        $apply->update([
            'status'=>'2',
        ]);

        if($apply){
            return $this->apiResponse($apply,'this application rejected',201);
        }

    }

    public function ban_application($id){
        $application = Application::find($id);

        if(!$application){
            return $this->apiResponse(null,'the application not found',404);
        }

        $application->update([
            'flag'=>'0',
        ]);

        if($application){
            return $this->apiResponse($application,'this application baned',201);
        }
    }


}
