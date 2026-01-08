<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use App\Models\FavoriteMovie;
use Illuminate\Support\Collection;

interface FavoriteMovieRepositoryInterface
{
    public function add(User $user, array $data): FavoriteMovie;
    public function remove(User $user, int $tmdbMovieId): void;
    public function listByUser(User $user): Collection;
}
