<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Sample;
use App\Models\SampleDetail;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kaolin = Material::where('slug', 'kaolin')->first();
        $limestone = Material::where('slug', 'limestone')->first();
        
        $fe2o3 = Material::where('slug', 'fe2o3')->first();
        $cao = Material::where('slug', 'cao')->first();
        $sio2 = Material::where('slug', 'sio2')->first();

        // 1. Successful Kaolin Sample
        $s1 = Sample::create([
            'material_id' => $kaolin->id,
            'sample_no' => 'LAB-001',
            'test_date' => Carbon::now()->subDays(2),
            'operator' => 'Budi Santoso',
            'status' => 'Layak Kirim',
        ]);
        $s1->details()->create(['material_id' => $fe2o3->id, 'value' => 0.004]); // 0.4% (< 0.5%)
        $s1->details()->create(['material_id' => $sio2->id, 'value' => 0.65]);

        // 2. Failed Kaolin Sample
        $s2 = Sample::create([
            'material_id' => $kaolin->id,
            'sample_no' => 'LAB-002',
            'test_date' => Carbon::now()->subDays(1),
            'operator' => 'Siti Aminah',
            'status' => 'Tidak Layak',
        ]);
        $s2->details()->create(['material_id' => $fe2o3->id, 'value' => 0.007]); // 0.7% (> 0.5%)

        // 3. Successful Limestone Sample
        $s3 = Sample::create([
            'material_id' => $limestone->id,
            'sample_no' => 'LAB-003',
            'test_date' => Carbon::now(),
            'operator' => 'Agus Wijaya',
            'status' => 'Layak Kirim',
        ]);
        $s3->details()->create(['material_id' => $cao->id, 'value' => 0.92]); // 92% (> 90%)
    }
}
