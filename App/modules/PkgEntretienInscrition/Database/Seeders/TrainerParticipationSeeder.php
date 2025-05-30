<?php

namespace  Modules\PkgEntretienInscrition\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgEntretienInscrition\App\Models\Trainer;
use Modules\PkgEntretienInscrition\App\Models\Participation;

class TrainerParticipationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $participations = Participation::whereIn('status', ['pending', 'completed'])
      ->get();

    $trainers = Trainer::all();

    for ($i = 0; $i < 10 && isset($participations[$i]); $i++) {
      $participations[$i]->trainers()->attach([
        $trainers[0]->id,
        $trainers[1]->id,
      ]);
    }

    for ($i = 10; $i < 20 && isset($participations[$i]); $i++) {
      $participations[$i]->trainers()->attach([
        $trainers[2]->id,
        $trainers[3]->id,
      ]);
    }
  }
}
