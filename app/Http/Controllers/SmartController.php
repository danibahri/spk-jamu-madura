<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Jamu;
use App\Models\SearchHistory;
use App\Services\SmartAlgorithmService;
use Illuminate\Support\Facades\Auth;

class SmartController extends Controller
{
    private $smartService;

    public function __construct(SmartAlgorithmService $smartService)
    {
        $this->smartService = $smartService;
    }

    public function index()
    {
        $categories = Jamu::distinct('kategori')->pluck('kategori')->toArray();

        return view('smart.index', compact('categories'));
    }

    public function calculate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'weights.kandungan' => 'required|numeric|min:0|max:100',
            'weights.khasiat' => 'required|numeric|min:0|max:100',
            'weights.harga' => 'required|numeric|min:0|max:100',
            'weights.expired' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            alert()->error('Validasi Gagal', 'Pastikan semua bobot kriteria diisi dengan benar (0-100).');
            return back()->withErrors($validator)->withInput();
        }

        $weights = $request->input('weights');
        $filters = $request->input('filters', []);

        // Normalize weights
        $weights = $this->smartService->normalizeWeights($weights);

        // Build query with filters
        $query = Jamu::query();
        $query = $this->smartService->applyFilters($query, $filters);

        $jamus = $query->get();

        if ($jamus->isEmpty()) {
            alert()->warning('Tidak Ditemukan', 'Tidak ada jamu yang sesuai dengan kriteria yang dipilih.');
            return back();
        }

        // Calculate SMART scores
        $results = $this->smartService->calculateSmart($jamus, $weights, $filters);

        // Ensure results is always an array and handle null/empty cases
        if (!is_array($results) || $results === null) {
            $results = [];
        }

        // If no results after calculation, show warning
        if (empty($results)) {
            alert()->warning('Tidak Ada Hasil', 'Tidak dapat menghitung rekomendasi dengan kriteria yang diberikan.');
            return back();
        }

        // Save to search history if user is logged in
        if (Auth::check()) {
            SearchHistory::create([
                'user_id' => Auth::id(),
                'search_query' => $request->input('search_query'),
                'criteria_weights' => $weights,
                'filters_applied' => $filters,
                'results' => array_slice($results, 0, 10) // Save top 10 results
            ]);
        }

        alert()->success('Berhasil!', 'Rekomendasi jamu berhasil dihitung dengan ' . (is_array($results) ? count($results) : 0) . ' hasil ditemukan.');

        return view('smart.results', compact('results', 'weights', 'filters'));
    }

    public function compare(Request $request)
    {
        $jamuIds = $request->input('jamus', []);

        if (count($jamuIds) < 2 || count($jamuIds) > 4) {
            alert()->error('Error', 'Pilih 2-4 jamu untuk dibandingkan.');
            return back();
        }

        $jamus = Jamu::whereIn('id', $jamuIds)->get();
        $weights = $this->smartService->getDefaultWeights();

        $comparisons = [];
        foreach ($jamus as $jamu) {
            $comparisons[] = [
                'jamu' => $jamu,
                'scores' => $this->smartService->getNormalizedScores($jamu, $weights),
                'total_score' => $this->smartService->calculateJamuScore($jamu, $weights)
            ];
        }

        return view('smart.compare', compact('comparisons', 'weights'));
    }
}
