<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Sample;
use App\Models\Rule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SampleController extends Controller
{
    /**
     * List all test reports.
     */
    public function index(Request $request)
    {
        $query = Sample::with('material');

        if ($request->filled('material_id')) {
            $query->where('material_id', $request->material_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('month')) {
            $query->whereMonth('test_date', Carbon::parse($request->month)->month)
                  ->whereYear('test_date', Carbon::parse($request->month)->year);
        }

        $samples = $query->latest()->get();
        $materials = Material::all();

        return view('samples.index', compact('samples', 'materials'));
    }

    /**
     * Show form for new test.
     */
    public function create(Material $material)
    {
        return view('samples.create', compact('material'));
    }

    /**
     * Process test data and run Forward Chaining.
     */
    public function store(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'sample_no' => 'required|unique:samples,sample_no',
            'test_date' => 'required|date',
            'operator' => 'required|string',
            'fe2o3' => 'nullable|numeric',
            'cao' => 'nullable|numeric',
            'sio2' => 'nullable|numeric',
            'al2o3' => 'nullable|numeric',
            'caco3' => 'nullable|numeric',
            'loi' => 'nullable|numeric',
        ]);

        $material = Material::findOrFail($request->material_id);
        $rules = Rule::where('material_id', $material->id)->get();

        // Forward Chaining Logic
        // Start with "Layak Kirim", and if any rule fails, set to "Tidak Layak"
        // This assumes rules define the criteria for being "Layak Kirim"
        $status = 'Layak Kirim';
        $failedRules = [];

        foreach ($rules as $rule) {
            $paramValue = $request->input(strtolower(str_replace(' ', '', $rule->parameter)));
            
            if ($paramValue === null) continue;

            $passed = false;
            switch ($rule->operator) {
                case 'Kurang dari':
                    $passed = $paramValue < $rule->value;
                    break;
                case 'Lebih dari':
                    $passed = $paramValue > $rule->value;
                    break;
                case 'Kurang dari sama dengan':
                    $passed = $paramValue <= $rule->value;
                    break;
                case 'Lebih dari sama dengan':
                    $passed = $paramValue >= $rule->value;
                    break;
            }

            if (!$passed) {
                $status = 'Tidak Layak';
                $failedRules[] = $rule;
            }
        }

        $sample = Sample::create(array_merge($request->all(), ['status' => $status]));

        return redirect()->route('samples.show', $sample)
            ->with('status', 'Klasifikasi berhasil dilakukan.');
    }

    /**
     * Show sample details and classification result.
     */
    public function show(Sample $sample)
    {
        $sample->load('material.rules');
        return view('samples.show', compact('sample'));
    }
}
