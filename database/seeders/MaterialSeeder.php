<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            ['name' => 'Kaolin', 'slug' => 'kaolin', 'formula' => 'Fe2O3'],
            ['name' => 'Clay F1', 'slug' => 'clay-f1', 'formula' => 'CaO'],
            ['name' => 'Feldspar', 'slug' => 'feldspar', 'formula' => 'SiO2'],
            ['name' => 'Limestone', 'slug' => 'limestone', 'formula' => 'CaCo3'],
            ['name' => 'Clay Pasiran', 'slug' => 'clay-pasiran', 'formula' => 'SiO3'],
        ];

        foreach ($materials as $data) {
            Material::firstOrCreate(
                [
                    'slug' => $data['slug'],
                    'name' => $data['name'],
                    'formula' => $data['formula'],
                ]
            );
        }
    }
}
