<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AutherController extends Controller
{

    //  Register Method Psot
    public function register(Request $request){

         $request->validate([
             "name" => "required",
             "email" => "required|email|unique:authors",
             "password" => "required|confirmed",
             "phone_no" => "required"
         ]);


         $author = new Author();

         $author->name = $request->name;
         $author->email = $request->email;
         $author->phone_no = $request->phone_no;
         $author->password = bcrypt($request->password);

         $author->save();

         return response()->json([
             "status" => 1,
             "message" => "Author Created Success"
         ]);

    }

    // Login Method Post

    public function login(Request $request){

        //  $login_data = $request->validate([
        //      "email"  => "required",
        //      "password" => "required"
        //  ]);

        //  if(!auth()->attempt($login_data)){
        //     return response()->json([
        //         "status" => false,
        //         "message"  => "Invalid Cradentials"
        //     ]);
        //  }

        //  $token = auth()->user()->createToken("auth_token");


        //  return response()->json([
        //       "status"  => true,
        //       "message"  => "Authot Logggin in Success",
        //       "access_token"  => $token
        //  ]);


    }

    // Profile Method Get

    public function profile(){

        $user_data = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "User data",
            "data" => $user_data
        ]);

    }

    // LogOut Method Get

    public function logout(Request $request){


         $token = $request->user()->token();

         $token->revoke();


          return response()->json([
              "status"  => true,
              "message"  => "Author Logged Out"
          ]);


    }

}




