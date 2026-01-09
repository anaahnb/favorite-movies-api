<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\FavoriteMovie;
use App\Repositories\Contracts\FavoriteMovieRepositoryInterface;
use Illuminate\Support\Collection;

class FavoriteMovieRepository implements FavoriteMovieRepositoryInterface
{
  public function listByUser(User $user): Collection
  {
    return FavoriteMovie::where('user_id', $user->id)->orderByDesc('created_at')->get();
  }

  public function add(User $user, array $data): FavoriteMovie
  {
    return FavoriteMovie::firstOrCreate(
      [
        'user_id' => $user->id,
        'tmdb_movie_id' => $data['tmdb_movie_id'],
      ],
      [
        'title' => $data['title'],
        'poster_path' => $data['poster_path'] ?? null,
        'genre_ids' => $data['genre_ids'] ?? [],
      ]
    );
  }

  public function remove(User $user, int $tmdb_movie_id): void
  {
    FavoriteMovie::where('user_id', $user->id)->where('tmdb_movie_id', $tmdb_movie_id)->delete();
  }
}
