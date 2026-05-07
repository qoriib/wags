<?php

namespace Database\Seeders;

use App\Models\Parameter;
use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parameters = [
            ['name' => 'FeO', 'slug' => 'feo'],
            ['name' => 'CaO', 'slug' => 'cao'],
            ['name' => 'SiO', 'slug' => 'sio'],
            ['name' => 'AiO', 'slug' => 'aio'],
            ['name' => 'CaCO', 'slug' => 'caco'],
            ['name' => 'Lol', 'slug' => 'lol'],
        ];

        foreach ($parameters as $parameter) {
            Parameter::firstOrCreate(
                ['slug' => $parameter['slug']],
                ['name' => $parameter['name']]
            );
        }
    }
}
