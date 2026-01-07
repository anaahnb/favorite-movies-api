<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
  public function __construct(private AuthRepositoryInterface $repository) {}

  public function register(RegisterRequest $request)
  {
    return response()->json($this->repository->register($request->validated()), 201);
  }

  public function login(LoginRequest $request)
  {
    return response()->json($this->repository->login($request->validated()));
  }

  public function logout(Request $request)
  {
    $this->repository->logout($request->user());

    return response()->json(['message' => 'Logout realizado com sucesso']);
  }
}
