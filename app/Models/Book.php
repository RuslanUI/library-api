<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes to be converted to base types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'authorId' => 'integer',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'authorId',
    ];

    /**
     * Agent
     *
     * @var object
     */
    public function author()
    {
        return $this->belongsTo(Author::class, 'authorId', 'id');
    }
}
