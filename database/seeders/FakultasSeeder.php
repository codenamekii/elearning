<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use Illuminate\Database\Seeder;

class FakultasSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $fakultas = collect(['Teknik Informatika', 'Teknik Mesin', 'Teknik Elektro', 'Teknik Industri', 'Teknik Sipil']);

    $fakultas->each(function ($fk) {
      $arr = explode(' ', $fk);
      $singkatan = '';

      foreach ($arr as $kata) {
        $singkatan .= substr($kata, 0, 1);
      }

      Fakultas::create([
        'kd_fk' => $singkatan,
        'nama' => $fk,
      ]);
    });
  }
}
