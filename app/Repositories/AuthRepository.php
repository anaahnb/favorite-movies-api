<?php
namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthRepository implements AuthRepositoryInterface
{
  public function register(array $data)
  {
    $user = User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);

    return [
      'user' => $user,
      'token' => $user->createToken('api-token')->plainTextToken,
    ];
  }

  public function login(array $data)
  {
    $user = User::where('email', $data['email'])->first();

    if (! $user || ! Hash::check($data['password'], $user->password)) {
      throw ValidationException::withMessages([
        'email' => ['Credenciais inválidas.'],
      ]);
    }

    return [
      'user' => $user,
      'token' => $user->createToken('api-token')->plainTextToken,
    ];
  }

  public function logout($user)
  {
    $user->currentAccessToken()->delete();
  }
}
