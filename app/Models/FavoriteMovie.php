<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteMovie extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tmdb_movie_id',
        'title',
        'poster_path',
        'genre_ids',
    ];

    protected $casts = ['genre_ids' => 'array'];
}
