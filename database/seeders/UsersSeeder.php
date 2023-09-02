<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $users = [
      [
        'name' => 'Store Admin',
        'email' => 'admin@store.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
      ],
      [
        'name' => 'Store Editor',
        'email' => 'editor@store.com',
        'password' => Hash::make('password'),
        'role' => 'editor',
      ],
      [
        'name' => 'Store viewer',
        'email' => 'viewer@store.com',
        'password' => Hash::make('password'),
        'role' => 'viewer',
      ],
    ];

    foreach ($users as $userData) {
      $user = User::create([
        'name' => $userData['name'],
        'email' => $userData['email'],
        'password' => $userData['password'],
      ]);

      $user->roles()->attach(Role::where('slug', $userData['role'])->first());
    }
  }
}
