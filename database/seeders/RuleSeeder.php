<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Rule;
use Illuminate\Database\Seeder;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kaolin = Material::where('slug', 'kaolin')->first();
        $clayF1 = Material::where('slug', 'clay-f1')->first();
        $feldspar = Material::where('slug', 'feldspar')->first();
        $limestone = Material::where('slug', 'limestone')->first();
        $clayPasiran = Material::where('slug', 'clay-pasiran')->first();

        $rules = [
            [
                'material_id' => $kaolin->id,
                'parameter' => 'Fe2O3',
                'operator' => 'Kurang dari',
                'value' => 0.5,
                'result_status' => 'Layak Kirim',
            ],
            [
                'material_id' => $clayF1->id,
                'parameter' => 'CaO',
                'operator' => 'Lebih dari',
                'value' => 3,
                'result_status' => 'Layak Kirim',
            ],
            [
                'material_id' => $feldspar->id,
                'parameter' => 'Fe2O3',
                'operator' => 'Kurang dari',
                'value' => 0.3,
                'result_status' => 'Layak Kirim',
            ],
            [
                'material_id' => $limestone->id,
                'parameter' => 'CaCO3',
                'operator' => 'Lebih dari',
                'value' => 90,
                'result_status' => 'Layak Kirim',
            ],
            [
                'material_id' => $clayPasiran->id,
                'parameter' => 'SiO2',
                'operator' => 'Lebih dari',
                'value' => 80,
                'result_status' => 'Layak Kirim',
            ],
        ];

        foreach ($rules as $rule) {
            Rule::create($rule);
        }
    }
}
