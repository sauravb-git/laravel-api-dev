<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;


class StudentController extends Controller
{

     // Register
     public function register(Request $request){

        //  table email  gola k unique korbe j unique:student

        $request->validate([
            "name" => 'required',
            "email" => 'required | email | unique:student',
            "password" => "required | confirmed"
        ]);


        $student = new Student();

       $student->name = $request->name;
       $student->email =  $request->email;
       $student->password =  Hash::make($request->password);
       $student->phone_no = isset($request->phone_no) ? $request->phone_no : "";

       $student->save();

       return response()->json([
           "status" => 1,
           "message" =>  "student reg success"
       ]);
    }

    // Login Api
    public function login(Request $request){

      $request->validate([
          "email" => "required | email",
          "password" => "required"
      ]);
    //    match data base email address
      $student = Student::where("email" , "=", $request->email)->first();

      if(isset($student->id)){

       if(Hash::check($request->password,$student->password)){

           $token = $student->createToken("auth_token")->plainTextToken;

           return response()->json([
               "status" => 1,
               "message" => "Student Login Success",
               "access_token"   => $token
           ]);
       }else{
        return response()->json([
            "status" => 0,
            "message" => "password did not match"
        ],404);
    }
      }else{

        return response()->json([
            "status" => 0,
            "message" => "Student Not Found"
        ],404);
      }
    }

    // Profile Api
    public function profile(){

        // user ar details pawr jonno tokon
        // make kore login hober jonno

        return response()->json([
            "status" => 1,
            "message" => "Student Profile Information",
            "data" => auth()->user()
        ]);

    }

    // Login Api
    public function logout(){


        // logout hole oi token ta delete kore fale

        // auth()->user()->tokens()->delete();

        return response()->json([
            "status" => 1,
            "message" => "Student Logged out Successfully"
        ]);

    }

}



