<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class ApiController extends Controller
{
    // Create Api POST
    public  function createEmployee(Request $request){

        // validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:employee",
            "phone_no" => "required",
            "gender" => "required",
            "age" => "required"
        ]);

        // create_function
        $employee = new Employee();

        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone_no = $request->phone_no;
        $employee->gender = $request->gender;
        $employee->age = $request->age;

        $employee->save();

        // send response
        return response()->json([
            "status" => 1,
            "message" => "Employee Created Successfully"
        ]);
    }

    // list Api GET
    public function listEmployee(){
        $employeeList = Employee::get();

        return response()->json([
            "status" => 1,
            "message" => "Listing Employess",
            "data"   => $employeeList
        ],200);

    }

    // Get Single APi GET
    public function getSingleEmployee($id){

        if(Employee::where("id", $id)->exists()){

            $employee_user = Employee::where("id",$id)->first();
            return response()->json([
                "status" => 1,
                "message" => "Employee Found",
                "data"  =>   $employee_user
            ]);

        }else{
            return response()->json([
                "status" => 0,
                "message" => "not found"
            ],404);
        }

    }

    // Update Api PUT
    public function updateEmployee(Request $request,$id) {
        if(Employee::where("id",$id)->exists()){

           $employee = Employee::find($id);

           $employee->name = !empty($request->name) ? $request->name : $request->name;
           $employee->email = !empty($request->email) ? $request->email : $request->email;
            $employee->phone_no = !empty($request->phone_no) ? $request->phone_no : $request->phone_no;
            $employee->gender = !empty($request->gender) ? $request->gender : $request->gender;
            $employee->age = !empty($request->age) ? $request->age : $request->age;


            $employee->save();
            return response()->json([
                "status" => 1,
                "message" => "Employee Updata Successfully"
            ]);
        }else{

            return response()->json([
                "status" => 0,
                "message" => "not found"
            ],404);
        }

    }

    // Delete Api DELETE
    public function deleteEmployee($id) {


        if(Employee::where("id", $id)->exists()){

            $employee_delete = Employee::find($id);

            $employee_delete->delete();
            return response()->json([
                "status" => 1,
                "message" => "Employee delete successfull"
            ]);

        }else{

            return response()->json([
                "status" => 0,
                "message" => "not found"
            ],404);
        }


    }

}
