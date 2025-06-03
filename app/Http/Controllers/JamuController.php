<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jamu;
use App\Models\Favorite;
use App\Models\SearchHistory;
use Illuminate\Support\Facades\Auth;

class JamuController extends Controller
{
    public function index(Request $request)
    {
        $query = Jamu::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->where('nama_jamu', 'like', '%' . $request->search . '%')
                ->orWhere('kandungan', 'like', '%' . $request->search . '%')
                ->orWhere('khasiat', 'like', '%' . $request->search . '%');

            // Save search history if user is logged in
            if (Auth::check()) {
                // Check for recent identical searches to avoid duplicates
                $recentSearch = SearchHistory::where('user_id', Auth::id())
                    ->where('search_query', $request->search)
                    ->where('created_at', '>=', now()->subMinutes(10))
                    ->first();

                if (!$recentSearch) {
                    // Get user preferences for criteria weights if available
                    $preference = Auth::user()->preference;
                    $criteriaWeights = null;

                    if ($preference) {
                        $criteriaWeights = [
                            'kandungan' => $preference->weight_kandungan,
                            'khasiat' => $preference->weight_khasiat,
                            'harga' => $preference->weight_harga,
                            'expired' => $preference->weight_expired
                        ];
                    }

                    SearchHistory::create([
                        'user_id' => Auth::id(),
                        'search_query' => $request->search,
                        'filters_applied' => json_encode($request->except(['_token', 'page'])),
                        'criteria_weights' => $criteriaWeights ? json_encode($criteriaWeights) : null,
                        'results' => null // Optional: store result IDs or count
                    ]);
                }
            }
        }

        // Category filter
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Price range filter
        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->harga_min);
        }

        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', $request->harga_max);
        }

        // Kandungan filter
        if ($request->filled('kandungan')) {
            $query->where('kandungan', 'like', '%' . $request->kandungan . '%');
        }

        // Sorting
        $sort = $request->get('sort', 'nama');

        switch ($sort) {
            case 'harga_asc':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_desc':
                $query->orderBy('harga', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'khasiat':
                $query->orderBy('nilai_khasiat', 'desc');
                break;
            case 'kandungan':
                $query->orderBy('nilai_kandungan', 'desc');
                break;
            default:
                $query->orderBy('nama_jamu', 'asc');
                break;
        }

        // Only show non-expired items
        $query->where('expired_date', '>', now());

        $jamus = $query->paginate(12);
        $total = Jamu::count();
        $categories = Jamu::distinct('kategori')->pluck('kategori')->filter()->values();
        $kandunganList = Jamu::distinct('kandungan')->pluck('kandungan')->filter()->values();

        // Price range for filters
        $priceRange = [
            'min' => Jamu::min('harga'),
            'max' => Jamu::max('harga')
        ];

        return view('jamu.index', compact('jamus', 'total', 'categories', 'kandunganList', 'priceRange'));
    }

    public function show($id)
    {
        $jamu = Jamu::findOrFail($id);

        // Get related jamus (same category)
        $relatedJamus = Jamu::where('kategori', $jamu->kategori)
            ->where('id', '!=', $jamu->id)
            ->where('expired_date', '>', now())
            ->limit(4)
            ->get();

        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = Favorite::where('user_id', Auth::id())
                ->where('jamu_id', $jamu->id)
                ->exists();
        }

        return view('jamu.show', compact('jamu', 'relatedJamus', 'isFavorite'));
    }

    public function category($category)
    {
        $jamus = Jamu::where('kategori', $category)
            ->where('expired_date', '>', now())
            ->paginate(12);

        $categories = Jamu::distinct('kategori')->pluck('kategori')->filter()->values();

        return view('jamu.category', compact('jamus', 'category', 'categories'));
    }

    public function compare(Request $request)
    {
        $jamuIds = $request->input('jamus', []);

        if (empty($jamuIds) || count($jamuIds) < 2) {
            return redirect()->back()->with('error', 'Pilih minimal 2 jamu untuk dibandingkan.');
        }

        if (count($jamuIds) > 4) {
            return redirect()->back()->with('error', 'Maksimal 4 jamu yang dapat dibandingkan.');
        }

        $jamus = Jamu::whereIn('id', $jamuIds)->get();

        return view('jamu.compare', compact('jamus'));
    }

    public function search(Request $request)
    {
        $term = $request->input('q');

        if (!$term) {
            return response()->json([]);
        }

        $jamus = Jamu::where('nama_jamu', 'like', '%' . $term . '%')
            ->orWhere('kandungan', 'like', '%' . $term . '%')
            ->orWhere('khasiat', 'like', '%' . $term . '%')
            ->where('expired_date', '>', now())
            ->limit(10)
            ->get(['id', 'nama_jamu', 'kategori', 'harga', 'khasiat']);

        return response()->json($jamus);
    }

    public function getCategories()
    {
        $categories = Jamu::distinct('kategori')
            ->pluck('kategori')
            ->filter()
            ->values();

        return response()->json($categories);
    }

    public function getKandunganList()
    {
        $kandungan = Jamu::distinct('kandungan')
            ->pluck('kandungan')
            ->filter()
            ->values();

        return response()->json($kandungan);
    }
}
