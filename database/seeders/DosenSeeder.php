<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DosenSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $dosen = Dosen::create([
      'nip' => 1009128129,
      'nama' => 'Herlinah S.Kom',
      'email' => 'dosen@gmail.com',
      'password' => bcrypt('password'),
      'foto' => 'default.png'
    ]);

    $randDosen = Dosen::all();
    $randDosen->each(function ($dsn) {
      $dsn->assignRole('dosen');
    });
  }
}
