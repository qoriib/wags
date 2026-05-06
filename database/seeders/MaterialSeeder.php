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
            ['name' => 'Kaolin', 'slug' => 'kaolin'],
            ['name' => 'Limestone', 'slug' => 'limestone'],
            ['name' => 'Clay F1', 'slug' => 'clay-f1'],
            ['name' => 'Feldspar', 'slug' => 'feldspar'],
            ['name' => 'Clay Pasiran', 'slug' => 'clay-pasiran'],
        ];

        foreach ($materials as $material) {
            Material::create($material);
        }
    }
}
