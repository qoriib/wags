<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Parameter;
use App\Models\Sample;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kaolin = Material::where('slug', 'kaolin')->first();
        $clayF1 = Material::where('slug', 'clay-f1')->first();
        $limestone = Material::where('slug', 'limestone')->first();

        $parameterMap = Parameter::pluck('id', 'slug')->all();

        // 1. Successful Kaolin Sample
        $s1 = Sample::create([
            'material_id' => $kaolin->id,
            'sample_no' => 'LAB-001',
            'test_date' => Carbon::now()->subDays(2),
            'operator' => 'Budi Santoso',
            'status' => 'Layak Kirim',
        ]);
        if (isset($parameterMap['feo'])) {
            $s1->details()->create(['parameter_id' => $parameterMap['feo'], 'value' => 0.004]); // 0.4% (< 0.5%)
        }
        if (isset($parameterMap['sio'])) {
            $s1->details()->create(['parameter_id' => $parameterMap['sio'], 'value' => 0.65]);
        }

        // 2. Failed Kaolin Sample
        $s2 = Sample::create([
            'material_id' => $kaolin->id,
            'sample_no' => 'LAB-002',
            'test_date' => Carbon::now()->subDays(1),
            'operator' => 'Siti Aminah',
            'status' => 'Tidak Layak',
        ]);
        if (isset($parameterMap['feo'])) {
            $s2->details()->create(['parameter_id' => $parameterMap['feo'], 'value' => 0.007]); // 0.7% (> 0.5%)
        }

        // 3. Successful Clay F1 Sample
        $s3 = Sample::create([
            'material_id' => $clayF1->id,
            'sample_no' => 'LAB-003',
            'test_date' => Carbon::now(),
            'operator' => 'Agus Wijaya',
            'status' => 'Layak Kirim',
        ]);
        if (isset($parameterMap['cao'])) {
            $s3->details()->create(['parameter_id' => $parameterMap['cao'], 'value' => 0.035]); // 3.5% (> 3%)
        }

        // 4. Successful Limestone Sample
        $s4 = Sample::create([
            'material_id' => $limestone->id,
            'sample_no' => 'LAB-004',
            'test_date' => Carbon::now()->subHours(4),
            'operator' => 'Rina Kurnia',
            'status' => 'Layak Kirim',
        ]);
        if (isset($parameterMap['caco'])) {
            $s4->details()->create(['parameter_id' => $parameterMap['caco'], 'value' => 0.93]); // 93% (> 90%)
        }
    }
}
