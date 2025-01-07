<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $kelas = collect([
      'TF.A1',
      'TF.A2',
      'TF.A3',
      'TF.A4',
      'TM.A1',
      'TM.A2',
      'TM.A3',
      'TM.A4',
      'TE.A1',
      'TE.A2',
      'TE.A3',
      'TE.A4',
      'TI.A1',
      'TI.A2',
      'TI.A3',
      'TI.A4',
      'TS.A1',
      'TS.A2',
      'TS.A3',
      'TS.A4',
    ]);

    $kelas->each(function ($item) {
      Kelas::create(['kd_kelas' => $item]);
    });
  }
}
