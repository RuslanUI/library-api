<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Author extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $rating = 0;
        if($this->rating > 0){
            $rating = $this->rating/$this->countRating;
        } 
        $response = [
            'id' => $this->id,
            'authorName' => $this->authorName,
            'rating' => $rating,
            'created_at' => $this->created_at->format('d.m.Y'),
            'updated_at' => $this->updated_at->format('d.m.Y'),
        ];
        if($request->has('all')){
            $response['books'] = Book::collection($this->books);
        }
        return $response;
    }
}
