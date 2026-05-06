<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    /**
     * Display the rules settings page.
     */
    public function index()
    {
        $rules = Rule::with('material')->get();
        $materials = Material::all();
        
        return view('settings.index', compact('rules', 'materials'));
    }

    /**
     * Store a new classification rule.
     */
    public function store(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'operator' => 'required|in:<,>,<=,>=',
            'value' => 'required|numeric',
        ]);

        Rule::create($request->all());

        return redirect()->back()->with('success', 'Aturan berhasil ditambahkan.');
    }

    /**
     * Update a rule.
     */
    public function update(Request $request, Rule $rule)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'operator' => 'required|in:<,>,<=,>=',
            'value' => 'required|numeric',
        ]);

        $rule->update($request->all());

        return redirect()->back()->with('success', 'Aturan berhasil diperbarui.');
    }

    /**
     * Remove a rule.
     */
    public function destroy(Rule $rule)
    {
        $rule->delete();

        return redirect()->back()->with('success', 'Aturan berhasil dihapus.');
    }
}
