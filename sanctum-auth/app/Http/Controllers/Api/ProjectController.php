<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;



class ProjectController extends Controller
{
     // Create Project
     public function createProject(Request $request){

        $request->validate([
           "name" => "required",
           "description"  => "required",
           "duration" => "required"
        ]);

        //  create student  id
        $student_id = auth()->user()->id;

        $project = new Project();

         $project->student_id = $student_id;
         $project->name = $request->name;
         $project->description = $request->description;
         $project->duration = $request->duration;

         $project->save();

         return response()->json([
             "status"  => 1,
             "message" => "project has been created"
         ]);

   }

   // List Project
   public function listProject()
   {
      $student_id = auth()->user()->id;

      $project = Project::where("student_id",$student_id)->get();

      return response()->json([
          "status" => 1,
          "message" => "Projects",
          "data" =>$project
      ]);


   }

   // Single Project
   public function singleProject($id){

        $student_id = auth()->user()->id;

        if(Project::where([
            "id" => $id,
            "student_id" => $student_id
        ])->exists()){

            $details = Project::where([
               "id" => $id,
               "student_id" => $student_id
            ])->first();

            return response()->json([
                "status" => 1,
                "message" => "Project not found",
                "data"  => $details
            ]);


        }else{
            return response()->json([
                "status" => 1,
                "message" => "Project not found"
            ]);

        }


   }

   // Delete Project
   public function deleteProject($id){

         $student_id = auth()->user()->id;

         if(Project::where([
             "id" => $id,
             "student_id" => $student_id
         ])->exists()){

              $project = Project::where([
                  "id" => $id,
                  "student_id" => $student_id
              ]);

         }else{
            return response()->json([
                "status" => 1,
                "message" => "Project not found"
            ]);
         }



   }







}





