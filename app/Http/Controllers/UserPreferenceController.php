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
            'weight_kandungan' => 'required|numeric|min:0|max:1',
            'weight_khasiat' => 'required|numeric|min:0|max:1',
            'weight_harga' => 'required|numeric|min:0|max:1',
            'weight_expired' => 'required|numeric|min:0|max:1',
        ]);

        // Validate that weights sum to approximately 1.0
        $totalWeight = $request->weight_kandungan + $request->weight_khasiat +
            $request->weight_harga + $request->weight_expired;

        if (abs($totalWeight - 1.0) > 0.01) {
            return back()->withErrors(['weights' => 'Total bobot kriteria harus sama dengan 1.0']);
        }

        UserPreference::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only([
                'health_condition',
                'preferred_categories',
                'min_price',
                'max_price',
                'allergic_ingredients',
                'weight_kandungan',
                'weight_khasiat',
                'weight_harga',
                'weight_expired'
            ])
        );

        return redirect()->route('preferences.index')
            ->with('success', 'Preferensi berhasil disimpan!');
    }

    public function history()
    {
        $histories = Auth::user()->searchHistories()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('preferences.history', compact('histories'));
    }
}
