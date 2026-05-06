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

        // Prepare parameter values (convert percentages to 0-1 decimals)
        $rawParams = ['fe2o3', 'cao', 'sio2', 'al2o3', 'caco3', 'loi'];
        $processedParams = [];
        foreach ($rawParams as $p) {
            if ($request->has($p) && $request->input($p) !== null) {
                $processedParams[$p] = $request->input($p) / 100;
            }
        }

        // Forward Chaining Logic
        $status = 'Layak Kirim';
        foreach ($rules as $rule) {
            $paramKey = strtolower($material->chemical_formula);
            $paramValue = $processedParams[$paramKey] ?? null;
            
            if ($paramValue === null) continue;

            $passed = false;
            switch ($rule->operator) {
                case '<':  $passed = $paramValue < $rule->value; break;
                case '>':  $passed = $paramValue > $rule->value; break;
                case '<=': $passed = $paramValue <= $rule->value; break;
                case '>=': $passed = $paramValue >= $rule->value; break;
            }

            if (!$passed) {
                $status = 'Tidak Layak';
                break;
            }
        }

        // Save Sample Metadata
        $sample = Sample::create([
            'material_id' => $material->id,
            'sample_no' => $request->sample_no,
            'test_date' => $request->test_date,
            'operator' => $request->operator,
            'status' => $status,
        ]);

        // Save Sample Details
        foreach ($processedParams as $param => $value) {
            // Find the material record for this chemical compound
            $paramMaterial = Material::where('slug', strtolower($param))
                                    ->orWhere('name', $param)
                                    ->first();
            
            if ($paramMaterial) {
                $sample->details()->create([
                    'material_id' => $paramMaterial->id,
                    'value' => $value,
                ]);
            }
        }

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
