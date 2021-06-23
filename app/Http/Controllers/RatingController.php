<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends API
{
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
            'id' => 'required|integer',
            'type' => 'required|string|in:book,author',
            'rating' => 'required|numeric|min:1|max:5',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }       

        if(!$this->saveRating($input['id'], $input['type'], (float)$input['rating'])){
            return $this->sendError('Not found object for rating'); 
        }
        return $this->sendResponse([], 'Rating added successfully.');
        
    }

    private function saveRating(int $id, string $type, float $rating)
    {
        $item = null;
        switch($type){
            case 'book': 
                $item = Book::find($id);
                break;
            case 'author': 
                $item = Author::find($id);
                break;
        }
        if(is_null($item)){
            return false;
        }
        $item->countRating++;
        $item->rating += $rating;
        $item->save();
        return true;
    }
}
