<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Angkatan;

class AngkatanSeeder extends Seeder
{
    public function run(): void
    {
        $angkatans = [
            '2022',
            '2023',
            '2024',
            '2025',
        ];

        foreach ($angkatans as $tahun) {
            Angkatan::create([
                'tahun' => $tahun
            ]);
        }
    }
}
