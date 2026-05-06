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
        // 1. Define Actual Minerals (Minerals that can have samples)
        $minerals = [
            ['name' => 'Kaolin', 'slug' => 'kaolin', 'chemical_formula' => 'Fe2O3'],
            ['name' => 'Limestone', 'slug' => 'limestone', 'chemical_formula' => 'CaCO3'],
            ['name' => 'Clay F1', 'slug' => 'clay-f1', 'chemical_formula' => 'CaO'],
            ['name' => 'Feldspar', 'slug' => 'feldspar', 'chemical_formula' => 'Fe2O3'],
            ['name' => 'Clay Pasiran', 'slug' => 'clay-pasiran', 'chemical_formula' => 'SiO2'],
        ];

        // 2. Define Chemical Compounds (Parameters)
        $compounds = [
            ['name' => 'Fe2O3', 'slug' => 'fe2o3', 'chemical_formula' => null],
            ['name' => 'CaO', 'slug' => 'cao', 'chemical_formula' => null],
            ['name' => 'SiO2', 'slug' => 'sio2', 'chemical_formula' => null],
            ['name' => 'Al2O3', 'slug' => 'al2o3', 'chemical_formula' => null],
            ['name' => 'CaCO3', 'slug' => 'caco3', 'chemical_formula' => null],
            ['name' => 'LoI', 'slug' => 'loi', 'chemical_formula' => null],
        ];

        foreach (array_merge($minerals, $compounds) as $data) {
            Material::create($data);
        }
    }
}
