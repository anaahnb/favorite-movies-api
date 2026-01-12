<?php

namespace Database\Seeders;

use App\Models\FavoriteMovie;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavoriteMovieSeeder extends Seeder
{
  public function run(): void
  {
    $user = User::where('email', 'ana@gmail.com.br')->first();

    if (!$user) {
      return;
    }

    $favorites = [
      [
        'tmdb_movie_id' => 10315,
        'title' => 'O Fantástico Sr. Raposo',
        'poster_path' => '/1Ey4LYUzTqzizPNjcBi20pU9joC.jpg',
        'genre_ids' => [12, 16, 35, 10751],
        'created_at' => now()->subDay(),
        'updated_at' => now()->subDay(),
      ],
      [
        'tmdb_movie_id' => 965150,
        'title' => 'Aftersun',
        'poster_path' => '/kXk5veq5oOh6SefMyXq6xtUBevw.jpg',
        'genre_ids' => [18],
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ];

    foreach ($favorites as $favorite) {
      FavoriteMovie::updateOrCreate(
        [
          'user_id' => $user->id,
          'tmdb_movie_id' => $favorite['tmdb_movie_id'],
        ],
        array_merge($favorite, ['user_id' => $user->id])
      );
    }
  }
}
