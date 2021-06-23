<?php

namespace App\Http\Controllers;

use App\Http\Resources\Author as AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthorController extends API
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::all(); 
        if(isset($_REQUEST['order']) && in_array(Str::lower($_REQUEST['order']), ['desc', 'asc'])){
            $authors = Author::orderBy('rating', $_REQUEST['order'])->get();
        } 
        return $this->sendResponse(AuthorResource::collection($authors), 'Authors retrieved successfully.');
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
            'authorName' => 'required|string|unique:authors|max:255',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }      
        $author = Author::create($input);
   
        return $this->sendResponse(new AuthorResource($author), 'Author created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $author = Author::find($id);
        if (is_null($author)) {
            return $this->sendError('Author not found.');
        }   
        return $this->sendResponse(new AuthorResource($author), 'Author retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $input = $request->all();
   
        $validator = Validator::make($request->all(), [
            'authorName' => 'required|string|unique:authors|max:255',
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $author->authorName = $input['authorName'];
        $author->save();
   
        return $this->sendResponse(new AuthorResource($author), 'Author updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $author = Author::find($id);
        if (is_null($author)) {
            return $this->sendError('Author not found.');
        }   
        $author->delete();   
        return $this->sendResponse([], 'Author deleted successfully.');
    }
}
