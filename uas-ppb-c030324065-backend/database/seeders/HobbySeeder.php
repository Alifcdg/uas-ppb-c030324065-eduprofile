<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hobby;

class HobbySeeder extends Seeder
{
    public function run(): void
    {
        $hobbies = [
            'Programming',
            'Gaming',
            'Photography',
            'Videography',
            'Music',
            'Design',
        ];

        foreach ($hobbies as $hobby) {
            Hobby::create([
                'nama_hobby' => $hobby
            ]);
        }
    }
}
