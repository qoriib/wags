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
                'operator' => '<',
                'value' => 0.005, // 0.5%
            ],
            [
                'material_id' => $clayF1->id,
                'operator' => '>',
                'value' => 0.03, // 3%
            ],
            [
                'material_id' => $feldspar->id,
                'operator' => '<',
                'value' => 0.003, // 0.3%
            ],
            [
                'material_id' => $limestone->id,
                'operator' => '>',
                'value' => 0.9, // 90%
            ],
            [
                'material_id' => $clayPasiran->id,
                'operator' => '>',
                'value' => 0.8, // 80%
            ],
        ];

        foreach ($rules as $rule) {
            Rule::create($rule);
        }
    }
}
