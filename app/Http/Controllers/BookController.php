<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\Book as BookResource;
use App\Models\Author;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookController extends API
{
    
    private function checkExistAuthor(string $name){
        return Author::whereRaw("UPPER(authorName) = '". Str::upper($name)."'")->get()->first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book = Book::all();
        if(isset($_REQUEST['order']) && in_array(Str::lower($_REQUEST['order']), ['desc', 'asc'])){
            $book = Book::orderBy('rating', $_REQUEST['order'])->get();
        }            
        return $this->sendResponse(BookResource::collection($book), 'Books retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:books|max:255',
            'authorName' => 'required|string|max:255',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $author = $this->checkExistAuthor($input['authorName']);
        if(is_null($author)){
            $author = Author::create($input);
        }        
        $input['authorId'] = $author->id;
        $book = Book::create($input);
   
        return $this->sendResponse(new BookResource($book), 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {  
        $book = Book::find($id);
        if (is_null($book)) {
            return $this->sendError('Book not found.');
        }   
        return $this->sendResponse(new BookResource($book), 'Book retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $input = $request->all();
   
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:books|max:255',
            'authorName' => 'string|max:255',
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if(isset($input['authorName'])){
            $author = $this->checkExistAuthor($input['authorName']);
            if(!$author){
                $author = Author::create($input);
            }
            $book->authorId = $author->id;
        }
        $book->name = $input['name'];        
        $book->save();
   
        return $this->sendResponse(new BookResource($book), 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $book = Book::find($id);
        if (is_null($book)) {
            return $this->sendError('Book not found.');
        }   
        $book->delete();   
        return $this->sendResponse([], 'Book deleted successfully.');
    }
}
