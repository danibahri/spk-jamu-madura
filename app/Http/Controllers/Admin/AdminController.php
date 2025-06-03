<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jamu;
use App\Models\User;
use App\Models\Article;
use App\Models\SearchHistory;
use App\Models\Favorite;

class AdminController extends Controller
{
    public function __construct()
    {
        // Add admin middleware here if you have one
        // $this->middleware('admin');
    }

    public function dashboard()
    {
        $stats = [
            'total_jamu' => Jamu::count(),
            'total_users' => User::count(),
            'total_articles' => Article::count(),
            'searches_today' => SearchHistory::whereDate('created_at', today())->count(),
        ];

        // Recent data for dashboard
        $recent_jamus = Jamu::latest()->limit(5)->get();
        $recent_articles = Article::latest()->limit(3)->get();

        // Recent activities (search histories)
        $recent_activities = SearchHistory::with('user')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($search) {
                return [
                    'user_name' => $search->user->name ?? 'Guest',
                    'user_email' => $search->user->email ?? '',
                    'action' => 'Pencarian',
                    'details' => $search->search_term,
                    'time' => $search->created_at->diffForHumans()
                ];
            });

        // Category statistics
        $category_stats = Jamu::select('kategori')
            ->selectRaw('count(*) as count')
            ->groupBy('kategori')
            ->get();

        // Search trends (last 7 days)
        $search_trends = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = SearchHistory::whereDate('created_at', $date)->count();
            $search_trends->push([
                'date' => $date->format('M d'),
                'count' => $count
            ]);
        }

        return view('admin.dashboard', compact(
            'stats',
            'recent_jamus',
            'recent_articles',
            'recent_activities',
            'category_stats',
            'search_trends'
        ));
    }

    public function jamus(Request $request)
    {
        $query = Jamu::query();

        // Search
        if ($request->filled('search')) {
            $query->where('nama_jamu', 'like', '%' . $request->search . '%')
                ->orWhere('kandungan', 'like', '%' . $request->search . '%')
                ->orWhere('khasiat', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('expired_date', '>', now());
            } elseif ($request->status === 'expired') {
                $query->where('expired_date', '<=', now());
            }
        }

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name':
                $query->orderBy('nama_jamu', 'asc');
                break;
            case 'price_low':
                $query->orderBy('harga', 'asc');
                break;
            case 'price_high':
                $query->orderBy('harga', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $jamus = $query->paginate(20);
        $categories = Jamu::distinct('kategori')->pluck('kategori')->filter()->values();

        return view('admin.jamu.index', compact('jamus', 'categories'));
    }

    public function createJamu()
    {
        $categories = Jamu::getCategories();
        return view('admin.jamus.create', compact('categories'));
    }

    public function storeJamu(Request $request)
    {
        $request->validate([
            'nama_jamu' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'kandungan' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'khasiat' => 'required|string',
            'efek_samping' => 'nullable|string',
            'expired_date' => 'required|date|after:today',
            'nilai_kandungan' => 'required|integer|min:1|max:5',
            'nilai_khasiat' => 'required|integer|min:1|max:5',
            'deskripsi' => 'nullable|string',
            'cara_penggunaan' => 'nullable|string',
        ]);

        Jamu::create($request->all());

        return redirect()->route('admin.jamus')
            ->with('success', 'Jamu berhasil ditambahkan!');
    }

    public function editJamu($id)
    {
        $jamu = Jamu::findOrFail($id);
        $categories = Jamu::getCategories();
        return view('admin.jamus.edit', compact('jamu', 'categories'));
    }

    public function updateJamu(Request $request, $id)
    {
        $jamu = Jamu::findOrFail($id);

        $request->validate([
            'nama_jamu' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'kandungan' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'khasiat' => 'required|string',
            'efek_samping' => 'nullable|string',
            'expired_date' => 'required|date',
            'nilai_kandungan' => 'required|integer|min:1|max:5',
            'nilai_khasiat' => 'required|integer|min:1|max:5',
            'deskripsi' => 'nullable|string',
            'cara_penggunaan' => 'nullable|string',
        ]);

        $jamu->update($request->all());

        return redirect()->route('admin.jamus')
            ->with('success', 'Jamu berhasil diperbarui!');
    }

    public function destroyJamu($id)
    {
        $jamu = Jamu::findOrFail($id);
        $jamu->delete();

        return redirect()->route('admin.jamus')
            ->with('success', 'Jamu berhasil dihapus!');
    }

    public function users()
    {
        $users = User::with('preferences')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function analytics()
    {
        // Search analytics
        $searchData = SearchHistory::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Popular categories
        $categoryData = Jamu::selectRaw('kategori, COUNT(*) as count')
            ->groupBy('kategori')
            ->orderBy('count', 'desc')
            ->get();

        // User registrations
        $userRegistrations = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.analytics', compact('searchData', 'categoryData', 'userRegistrations'));
    }
}
