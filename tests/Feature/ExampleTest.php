<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesApplication;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use CreatesApplication;

    private $bookData = [
        "name" => "Онегин",
        "authorName" => "Пушкин Александр Сергеевич",
    ];

    /**
     * Создание книги.
     *
     * @return void
     */
    public function test_createBook()
    {   
        $this->json('POST', 'api/book', $this->bookData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "data" => [
                    "id",
                    "name",
                    "author",
                    "rating",
                    "created_at",
                    "updated_at"
                ],
                "message"
            ]);
        
    }

    /**
     * Повторное создание книги.
     *
     * @return void
     */
    public function test_createAgainBook()
    {         
        $this->json('POST', 'api/book', $this->bookData, ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    "name"                    
                ]
            ]);
        
    }


    /**
     * Обновление книги.
     *
     * @return void
     */
    public function test_updateBook()
    {
        $newBook = $this->bookData;
        $newBook['name'] = 'Евгений Онегин';
        $this->json('PUT', 'api/book/1', $newBook, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "data" => [
                    "id",
                    "name",
                    "author",
                    "rating",
                    "created_at",
                    "updated_at"
                ],
                "message"
            ]);
        
    }

    /**
     * Получение книги.
     *
     * @return void
     */
    public function test_getBook()
    {
        $this->json('GET', 'api/book/1', [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "data" => [
                    "id",
                    "name",
                    "author",
                    "rating",
                    "created_at",
                    "updated_at"
                ],
                "message"
            ]);
        
    }

    /**
     * Установка рейтинга книге.
     *
     * @return void
     */
    public function test_setRatingBook()
    {
        $params = [
            'id' => 1,
            'type' => 'book',
            'rating' => 5
        ];
        $this->json('POST', 'api/rating', $params, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "data" => [],
                "message"
            ]);
        
    }

    /**
     * Поиск книг.
     *
     * @return void
     */
    public function test_searchBook()
    {
        $search = $this->bookData['name'];
        $this->json('GET', 'api/search/'.$search, [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "data" => [
                    "books" => [],
                    "authors" => [],
                ],
                "message"
            ]);
        
    }

    /**
     * Поиск несуществующей книги.
     *
     * @return void
     */
    public function test_searchNotFoundBook()
    {
        $search = 'Неизвестно';
        $this->json('GET', 'api/search/'.$search, [], ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJsonStructure([
                "success",                
                "message"
            ]);
        
    }

    /**
     * Удаление книги.
     *
     * @return void
     */
    public function test_deleteBook()
    {
        $this->json('DELETE', 'api/book/1', [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "success", 
                "data",               
                "message"
            ]);
        
    }
}
