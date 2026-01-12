<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    User::updateOrCreate(
      ['email' => 'ana@gmail.com.br'],
      [
        'name' => 'Ana',
        'password' => Hash::make('password'),
      ]
    );
  }
}
