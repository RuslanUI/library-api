<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\Book as BookResource;
use App\Http\Resources\Author as AuthorResource;
use App\Models\Author;
use Illuminate\Support\Str;

class SearchController extends API
{
     /**
     * Display the specified resource.
     *
     * @param  string $search
     * @return \Illuminate\Http\Response
     */
    public function show(string $search)
    {  
        $result = [
            'books' => [],
            'authors' => []
        ];
        
        $books = Book::whereRaw("UPPER(name) LIKE '%". Str::upper($search)."%'")->get();
        if (count($books) > 0) {
            $result['books'] = BookResource::collection($books);
        }   
        $authors = Author::whereRaw("UPPER(authorName) LIKE '%". Str::upper($search)."%'")->get();
        if (count($authors) > 0) {
            $result['authors'] = AuthorResource::collection($authors);            
        }
        
        if($result['books'] || $result['authors']){
            return $this->sendResponse($result, 'Found success');
        }
        return $this->sendError('No results found for "'.$search.'"');
        
    }
}
