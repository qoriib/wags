<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Parameter;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
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

        $materials = [
            ['name' => 'Kaolin', 'slug' => 'kaolin', 'formula' => 'Fe2O3'],
            ['name' => 'Clay F1', 'slug' => 'clay-f1', 'formula' => 'CaO'],
            ['name' => 'Feldspar', 'slug' => 'feldspar', 'formula' => 'SiO2'],
            ['name' => 'Limestone', 'slug' => 'limestone', 'formula' => 'CaCo3'],
            ['name' => 'Clay Pasiran', 'slug' => 'clay-pasiran', 'formula' => 'SiO3'],
        ];

        foreach ($materials as $data) {
            Material::firstOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $data['name'],
                    'formula' => $data['formula'],
                ]
            );
        }
    }
}
