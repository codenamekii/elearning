<?php

namespace Database\Seeders;

use App\Models\Matkul;
use Illuminate\Database\Seeder;

class MatkulSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $matkuls = collect([
      'Algoritma dan Pemrograman',
      'Sistem Basis Data',
      'Jaringan Komputer',
      'Termodinamika',
      'Dinamika Mesin',
      'Mesin Fluida',
      'Elektronika Dasar',
      'Sistem Tenaga Listrik',
      'Sinyal Dan Sistem',
      'Mekanika Tanah',
      'Struktur Beton',
      'Hidrologi Terapan',
      'Manajemen Industri',
      'Ergonomi',
      'Manajemen Proyek',
    ]);
    $matkuls->each(function ($matkul) {
      $arr = explode(' ', $matkul);
      $singkatan = '';

      foreach ($arr as $kata) {
        $singkatan .= substr($kata, 0, 1);
      }

      Matkul::create([
        'kd_matkul' => $singkatan,
        'nm_matkul' => $matkul,
        'sks' => rand(1, 3)
      ]);
    });
  }
}
