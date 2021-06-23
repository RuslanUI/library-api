<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    /**
     * The attributes to be converted to base types.
     *
     * @var array
     */
    protected $casts = [
        'authorName' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'authorName',
    ];

    /**
     * Agent
     *
     * @var object
     */
    public function books()
    {
        return $this->hasMany(Book::class, 'authorId');
    }
}
