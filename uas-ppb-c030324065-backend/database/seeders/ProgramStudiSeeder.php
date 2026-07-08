<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramStudi;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        $programStudis = [
            'Teknik Informatika',
            'Sistem Informasi',
            'Teknik Mesin',
            'Teknik Elektro',
        ];

        foreach ($programStudis as $program) {
            ProgramStudi::create([
                'nama_program_studi' => $program
            ]);
        }
    }
}
