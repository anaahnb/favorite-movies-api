<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavoriteMovieRequest;
use App\Repositories\Contracts\FavoriteMovieRepositoryInterface;
use Illuminate\Http\Request;

class FavoriteMovieController extends Controller
{
    public function __construct(private FavoriteMovieRepositoryInterface $repository) {}

    public function index(Request $request)
    {
        $favorites = $this->repository->listByUser($request->user());

        return response()->json($favorites);
    }

    public function store(StoreFavoriteMovieRequest $request)
    {
        $favorite = $this->repository->add(
            $request->user(),
            $request->validated()
        );

        return response()->json($favorite, 201);
    }

    public function destroy(Request $request, int $tmdbMovieId)
    {
        $this->repository->remove($request->user(), $tmdbMovieId);

        return response()->json(null, 204);
    }
}

