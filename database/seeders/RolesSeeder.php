<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Schema::disableForeignKeyConstraints();
    DB::table('roles')->truncate();
    Schema::enableForeignKeyConstraints();

    $roles = [
      ['name' => 'Admin', 'slug' => 'admin'],
      ['name' => 'Editor', 'slug' => 'editor'],
      ['name' => 'Viewer', 'slug' => 'viewer'],
    ];

    collect($roles)->each(function ($role) {
      Role::create($role);
    });
  }
}
