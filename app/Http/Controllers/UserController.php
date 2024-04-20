<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplyFor;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function view_all_posts(){
        $applications = Application::with('company')->get();
        if($applications->isEmpty()){
            return $this->apiResponse(null,'there are no applications yet',404);
        }
        return $this->apiResponse($applications ,'ok',200);
    }

    public function apply_for_job(Request $request , $application_id){
        $validator = Validator::make($request->all(),[
            'cv'=>'required|max:255',
        ]);

        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }

        $cv = $request->file('cv')->store('CV');

        $apply = ApplyFor::create([
            'application_id'=>$application_id,
            'user_id'=>'1',
            'cv'=>$cv,
        ]);

        if($apply){
            return $this->apiResponse($apply,'you applied successfully ',201);
        }
        return $this->apiResponse(null,'you did not apply please try again',400);
    }

    public function update_profile(Request $request , $id){
        $validator = Validator::make($request->all(),[
            'Fname' => 'required|string',
            'Lname' => 'required|string',
            'password' => 'required|string|min:6',
            'phone' => 'required',
            'bio' => 'required',
            'age' => 'required',
            'degree' => 'required',
            'skills' => 'required',
            'years_of_experience' => 'required',
            'current_company' => 'required',
        ]);

        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }

        $user = User::find($id);
        if (!$user){
            return $this->apiResponse(null,'the user not found',404);
        }
        $user->update([
            'Fname' => $request->Fname,
            'Lname' => $request->Lname,
            'password' => $request->password,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'age' => $request->age,
            'degree' => $request->degree,
            'skills' => $request->skills,
            'years_of_experience' => $request->years_of_experience,
            'current_company' => $request->current_company,
        ]);

        if($user){
            return $this->apiResponse($user,'your info updated successfully ',201);
        }

    }

//    public function search_for_company(Request $request){
//        $search = $request->search;
//        $result = Company::where(function ($query) use ($search){
//            $query->where('username','like',"%$search%");
//        })->orWhereHas('applications',function ($query) use ($search){
//            $query->where('title','like',"%$search%");
//        })->get();
//
//        if($result->isEmpty()){
//            return $this->apiResponse(null,'there is no result',404);
//        }
//        return $this->apiResponse($result ,'ok',200);
//    }

    public function search_for_company(Request $request) {
        $search = $request->input('search');

        $result = Application::with('company')->where('title', 'like', "%$search%")->get();

        if ($result->isEmpty()) {
            return $this->apiResponse(null, 'No results found', 404);
        }

        return $this->apiResponse($result, 'OK', 200);
    }


}
