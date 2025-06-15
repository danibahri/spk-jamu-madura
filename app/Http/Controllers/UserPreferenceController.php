<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPreference;
use App\Models\Jamu;
use Illuminate\Support\Facades\Auth;

class UserPreferenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $preference = UserPreference::where('user_id', Auth::id())->first();
        $categories = Jamu::getCategories();
        $kandunganList = Jamu::getKandunganList();

        return view('preferences.index', compact('preference', 'categories', 'kandunganList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'health_condition' => 'nullable|string|max:255',
            'preferred_categories' => 'nullable|array',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'allergic_ingredients' => 'nullable|array',
            'weight_kandungan' => 'required|numeric|min:0|max:100',
            'weight_khasiat' => 'required|numeric|min:0|max:100',
            'weight_harga' => 'required|numeric|min:0|max:100',
            'weight_expired' => 'required|numeric|min:0|max:100',
        ]);

        // Auto-normalize weights from percentage to decimal
        $weights = [
            'weight_kandungan' => $request->weight_kandungan,
            'weight_khasiat' => $request->weight_khasiat,
            'weight_harga' => $request->weight_harga,
            'weight_expired' => $request->weight_expired,
        ];

        $totalWeight = array_sum($weights);
        if ($totalWeight > 0) {
            // Normalize to decimal (0-1)
            $weights = array_map(function ($weight) use ($totalWeight) {
                return $weight / $totalWeight;
            }, $weights);
        } else {
            // Default equal weights
            $weights = [
                'weight_kandungan' => 0.25,
                'weight_khasiat' => 0.25,
                'weight_harga' => 0.25,
                'weight_expired' => 0.25,
            ];
        }

        UserPreference::updateOrCreate(
            ['user_id' => Auth::id()],
            array_merge(
                $request->only([
                    'health_condition',
                    'preferred_categories',
                    'min_price',
                    'max_price',
                    'allergic_ingredients'
                ]),
                $weights
            )
        );

        return redirect()->route('preferences.index')
            ->with('success', 'Preferensi berhasil disimpan!');
    }
}
