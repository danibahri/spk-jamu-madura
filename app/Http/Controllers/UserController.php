<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jamu;
use App\Models\Favorite;
use App\Models\SearchHistory;
use App\Models\UserPreference;
use App\Models\Article;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();

        // Get user statistics
        $totalFavorites = Favorite::where('user_id', $user->id)->count();
        $totalSearches = SearchHistory::where('user_id', $user->id)->count();

        // Get recent favorites (renamed from recentFavorites to favorites to match view)
        $favorites = Favorite::with('jamu')
            ->where('user_id', $user->id)
            ->latest()
            ->take(6) // Show 6 favorites (3 rows x 2 columns)
            ->get();

        // Get recent search history
        $recentSearches = SearchHistory::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Get user preferences (single preference record)
        $userPreferences = UserPreference::where('user_id', $user->id)->first();

        // Get saved preferences (all preference records for dropdown)
        $savedPreferences = UserPreference::where('user_id', $user->id)
            ->latest()
            ->get();

        // Get recent articles
        $recentArticles = Article::latest()
            ->take(5)
            ->get();

        // Get recommended jamu based on user preferences
        $recommendedJamu = collect();
        if ($userPreferences) {
            $recommendedJamu = Jamu::when($userPreferences->preferred_category, function ($query, $category) {
                return $query->where('kategori', $category);
            })
                ->when($userPreferences->max_price, function ($query, $maxPrice) {
                    return $query->where('harga', '<=', $maxPrice);
                })
                ->inRandomOrder()
                ->take(3)
                ->get();
        }

        return view('user.dashboard', compact(
            'user',
            'totalFavorites',
            'totalSearches',
            'favorites', // Changed from recentFavorites to favorites
            'recentSearches',
            'userPreferences',
            'savedPreferences', // Added savedPreferences
            'recentArticles', // Added recentArticles
            'recommendedJamu'
        ));
    }
}
