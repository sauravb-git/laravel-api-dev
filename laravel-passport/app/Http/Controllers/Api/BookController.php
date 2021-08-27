<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Author;

class BookController extends Controller
{
    //  Create Method Post
     public function createBook(Request $request){

        $request->validate([
            "title"  => "required",
            "description" => "required",
            "book_const"  => "required"
        ]);

        $book = new Book();

        $book->author_id = auth()->user()->id;
        $book->title = $request->title;
        $book->description = $request->description;
        $book->book_const  = $request->book_const;

        $book->save();


       return response()->json([
           "status" => 1,
           "message" => "Book created successfull"
       ]);

     }
    //  Last Method get

    public function listBook(){


       $author_id = auth()->user()->id;
       $book = Author::find($author_id)->books;

       return response()->json([
           "status"  => 1,
           "message" => "ALl Books",
           "data"  => $book
       ]);

    }

    //  Single Book Method get
    public function singleBook($book_id){

        $author_id = auth()->user()->id;

        if(Book::where([
            "author_id"  => $author_id,
            "id"  => $book_id
        ])){

            $book_id = Book::find($book_id);

            return response()->json([
                "status" => true,
                "message" => "book data not found",
                "data"  => $book_id
            ]);
        }else{

            return response()->json([
                "status" => false,
                "message" => "Auther Book did not exists"
            ]);
        }

    }

    //  Update Method Post
    public function updataBook(Request $request,$book_id){
     $author_id = auth()->user()->id;

     if(Book::where([
        "author_id" => $author_id,
        "id" => $book_id
     ])){

        $book  = Book::find($book_id);

        $book->title = isset($request->title) ? $request->title : $book->title;
        $book->description =  isset($request->description) ? $request->description : $book->description;
        $book->book_const  = isset($request->book_const) ? $request->book_const : $book->book_const;

        $book->save();

        return response()->json([
            "status" => 1,
            "message"  => "Book data has been update"
        ]);


     }else{
         return response()->json([
          "status" => false,
          "message" => "Author Book Does not exists"
         ]);
     }


    }

    //  Delete Method get

    public function deleteBook($book_id){

       $author_id = auth()->user()->id;

       if(Book::where([
           "author_id" => $author_id,
           "id" => $book_id
       ])->exists()){
          $book = Book::find($book_id);

          $book->delete();

           return response()->json([
               "status" => true,
               "message"  => "Book has been delete"
           ]);


       }else{

        return response()->json([
            "status" => false,
            "message" => "Author Book does not exists"
        ]);
       }


    }

}
